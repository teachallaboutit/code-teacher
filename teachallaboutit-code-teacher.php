<?php
/*
Plugin Name: TeachAllAboutIt - SEN Friendly Code Teacher for Python
Description: An embeddable Python code editor to help students learn Python, with hints and SEN-friendly features.
Version: 1.1
Author: Holly Billinghurst
*/

// Register shortcode to embed the Python editor
defined('ABSPATH') or die("You can't access this file directly.");

// Database tables to store saved user code
register_activation_hook(__FILE__, 'create_code_editor_table');

function create_code_editor_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'python_tutorials_code';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
        user_id BIGINT(20) NOT NULL,
        tutorial_id BIGINT(20) NOT NULL,
        saved_code LONGTEXT NOT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY user_tutorial (user_id, tutorial_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function python_code_editor_enqueue_scripts() {
    // Enqueue CodeMirror CSS and JS
    wp_enqueue_style('codemirror-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css');
    wp_enqueue_script('codemirror-js', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js', array(), null, true);
    wp_enqueue_script('codemirror-python-js', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/python/python.min.js', array('codemirror-js'), null, true);
    // Enqueue custom CSS and JavaScript for plugin functionality
    wp_enqueue_style('python-editor-css', plugin_dir_url(__FILE__) . 'css/editor-styles.css');
    wp_enqueue_script(
        'python-editor-js',
        plugin_dir_url(__FILE__) . 'js/python-editor.js',
        array('codemirror-js', 'codemirror-python-js'),
        filemtime(plugin_dir_path(__FILE__) . 'js/python-editor.js'), // Use file modification time as version
        true
    );

    // Pass Ajax URL to JavaScript
    wp_localize_script('python-editor-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'python_code_editor_enqueue_scripts');

function python_code_editor_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(
        array(
            'tutorial' => '0',
        ),
        $atts
    );

    // Include tutorial content from an external file
    include plugin_dir_path(__FILE__) . 'tutorials.php';

    // Select the tutorial based on the attribute
    $tutorial = isset($tutorials[$atts['tutorial']]) ? $tutorials[$atts['tutorial']] : null;

    // Get the current user ID
    $user_id = get_current_user_id();
    $tutorial_id = intval($atts['tutorial']);

    // Check if the user has saved progress
    global $wpdb;
    $saved_code = '';
    if ($user_id) {
        $table_name = $wpdb->prefix . 'python_tutorials_code';
        $row = $wpdb->get_row(
            $wpdb->prepare("SELECT saved_code FROM $table_name WHERE user_id = %d AND tutorial_id = %d", $user_id, $tutorial_id)
        );

        $saved_code = $row ? $row->saved_code : '';
    }

    // Prepare tutorial content
    $title_text = $tutorial ? $tutorial['title'] : '';
    $challenge_text = $tutorial ? $tutorial['challenge'] : '';
    $skeleton_code = $tutorial ? $tutorial['skeleton_code'] : '';
    $example_answer = $tutorial ? $tutorial['example_answer'] : '';
    $hint_text = $tutorial ? $tutorial['hint'] : '';

    // Determine the initial code to load (if previously saved, student code loads, otherwise skeleton code will load)
    $initial_code = !empty($saved_code) ? $saved_code : $skeleton_code;

    // Editor HTML
    ob_start(); // Start output buffering
    ?>
    <div class="code-teacher-container">
        <div class="challenge-text"><h2><?php echo esc_attr($title_text); ?></h2><br/><?php echo $challenge_text; ?></div>
        <div class="editor-panel">
            <div class="editor-container">
                <div id="editor-container">
                    <div class="container-header">Your Python Code</div>
                    <div id="editor" data-tutorial-id="<?php echo esc_attr($tutorial_id); ?>" data-tutorial-code="<?php echo esc_html($initial_code); ?>"></div>
                </div>
                <div id="output-container">
                    <div class="container-header">Your Code Output</div>
                    <pre id="output"></pre>
                </div>
            </div>
            <div id="editor-controls">
                <button id="run-code">Run Code</button>
                <button id="save-code">Save Progress</button>
                <button id="hint-button">Hint</button>
                <button id="help-button">Help</button>
                <div id="hint-section" style="display: none;"><strong>Hint:</strong> <?php echo $hint_text; ?></div>
                
            </div>
            <div id="output-section">
                <img id="helper-character" src="<?php echo esc_url(plugins_url('img/Alex_Chat_Bot.png', __FILE__)); ?>" alt="Alex Help Character" style="display: none;">
                <div id="speech-bubble">Hi, it looks like you need help with your code...</div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean(); // Return the buffered content
}
add_shortcode('python_editor', 'python_code_editor_shortcode');

// Handle AJAX request to execute code
function python_code_editor_execute_code() {
    // Get the posted code
    $code = isset($_POST['code']) ? sanitize_textarea_field($_POST['code']) : '';

    if (empty($code)) {
        wp_send_json_error('Code is required.');
    }

    // Flask endpoint (currently hardcoded for testing)
    $api_url = 'https://teachallaboutit.pythonanywhere.com/api/execute';

    $response = wp_remote_post($api_url, array(
        'headers' => array('Content-Type' => 'application/json'),
        'body'    => json_encode(array('code' => $code)),
        'method'  => 'POST'
    ));

    if (is_wp_error($response)) {
        wp_send_json_error('Failed to contact the API: ' . $response->get_error_message());
    }

    $response_body = wp_remote_retrieve_body($response);
    $data = json_decode($response_body, true);

    if ($data && isset($data['success']) && $data['success']) {
        wp_send_json_success(['output' => $data['output']]);
    } else {
        $error_message = isset($data['output']) ? $data['output'] : 'Unexpected response format from the API.';
        wp_send_json_error($error_message);
    }
}
add_action('wp_ajax_execute_code', 'python_code_editor_execute_code');
add_action('wp_ajax_nopriv_execute_code', 'python_code_editor_execute_code');

// Handle AJAX request to get help from ChatGPT
function python_code_editor_get_chatgpt_help() {
    // Get the API key from settings
    $api_key = get_option('python_code_editor_chatgpt_api_key', '');
    if (empty($api_key)) {
        wp_send_json_error('API key not set.');
    }

    // Get the data from the request
    $challenge = isset($_POST['challenge']) ? sanitize_textarea_field($_POST['challenge']) : '';
    $student_code = isset($_POST['student_code']) ? sanitize_textarea_field($_POST['student_code']) : '';
    $example_answer = isset($_POST['example_answer']) ? sanitize_textarea_field($_POST['example_answer']) : '';

    if (empty($challenge) || empty($student_code) || empty($example_answer)) {
        wp_send_json_error('All fields are required.');
    }

    // Prepare the prompt
    $prompt = "This is a Python code challenge that has been set for kids aged 12 to 14: " . $challenge . "\nStudent's code: " . $student_code . "\nExample answer: " . $example_answer . "\nProvide some advice using child friendly language of up to 100 characters on next steps or errors, without giving the answer. For code more than 10 lines long, indicate a line number to look at. Please word the response as if you are a British friend of the same age and don't truncate sentences. Please don't call them names like pal, buddy, or mate.";

    // Call ChatGPT API with GPT-4 model
    $api_url = 'https://api.openai.com/v1/chat/completions';
    $response = wp_remote_post($api_url, array(
        'headers' => array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $api_key,
        ),
        'body'    => json_encode(array(
            'model' => 'gpt-4',
            'messages' => array(
                array('role' => 'system', 'content' => 'You are a helpful tutor.'),
                array('role' => 'user', 'content' => $prompt)
            ),
            'max_tokens' => 40,
            'temperature' => 0.7,
        )),
        'method'  => 'POST'
    ));

    if (is_wp_error($response)) {
        wp_send_json_error('Failed to contact the API: ' . $response->get_error_message());
    }

    $response_body = wp_remote_retrieve_body($response);
    $data = json_decode($response_body, true);

    // Updated response handling for GPT-4
    if (isset($data['choices'][0]['message']['content'])) {
        $advice = trim($data['choices'][0]['message']['content']);
        wp_send_json_success($advice);
    } else {
        // Log unexpected response for debugging
        error_log('Unexpected API response: ' . print_r($data, true));
        wp_send_json_error('Unexpected response format from the API. Please check logs for more details.');
    }
}
add_action('wp_ajax_get_chatgpt_help', 'python_code_editor_get_chatgpt_help');
add_action('wp_ajax_nopriv_get_chatgpt_help', 'python_code_editor_get_chatgpt_help');

// Saving User Progress
function save_user_code() {
    global $wpdb;

    // Get user ID and tutorial ID from the AJAX request
    $user_id = get_current_user_id();
    $tutorial_id = intval($_POST['tutorial_id']);
    $saved_code = wp_unslash($_POST['code']); // stops the backslashes appearing when loaded


    if (!$user_id) {
        wp_send_json_error('User not logged in.');
        return;
    }

    $table_name = $wpdb->prefix . 'python_tutorials_code';

    // Insert or update the saved code
    $wpdb->replace(
        $table_name,
        array(
            'user_id' => $user_id,
            'tutorial_id' => $tutorial_id,
            'saved_code' => $saved_code,
        ),
        array(
            '%d', // user_id
            '%d', // tutorial_id
            '%s'  // saved_code
        )
    );

    wp_send_json_success('Code saved successfully.');
}
add_action('wp_ajax_save_user_code', 'save_user_code');

function load_python_code_function() {
    // Load the saved code from the database if it exists

    $user_id = get_current_user_id();
    $tutorial_id = intval($_POST['tutorial_id']);
    
    if (!$user_id) {
        wp_send_json_error('User not logged in.');
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'python_tutorials_code';
    $row = $wpdb->get_row(
        $wpdb->prepare("SELECT saved_code FROM $table_name WHERE user_id = %d AND tutorial_id = %d", $user_id, $tutorial_id)
    );

    // Set your skeleton code, which can vary depending on the tutorial.
    $skeleton_code = "print('Hello, World!')"; // Example skeleton code

    if ($row) {
        wp_send_json_success(['code' => htmlspecialchars_decode($row->saved_code)]); // removes the backslashes from the saved code
    } else {
        wp_send_json_error(['code' => $skeleton_code]);
    }
}
add_action('wp_ajax_load_python_code', 'load_python_code_function');
?>
