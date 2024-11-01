<?php
/*
Plugin Name: TeachAllAboutIt - SEN Friendly Code Teacher for Python
Plugin URI: https://teachAllAboutIt.uk/plugins
Description: An embeddable Python code editor to help students learn Python, with hints and SEN-friendly features.
Version: 1.1.0
Author: Holly Billinghurst
Author URI: https://teachAllAboutIt.uk/plugins
License: GPL2

// Changelog:
// Version 1.1.0
// - On screen Python Editor.
// - Code save feature with timestamp for teacher reports
// - chatGPT helper feature to analyse code currently on
// - Updated UI for the teacher report page.
// Version 1.0.0
// - Initial release.
*/


// Register shortcode to embed the Python editor
defined('ABSPATH') or die("You can't access this file directly.");



// Database tables to store saved user code
register_activation_hook(__FILE__, 'create_code_editor_table');

function python_code_editor_enqueue_scripts() {
    global $post;

    // Check if the current post content contains the `python_editor` shortcode
    if (has_shortcode($post->post_content, 'python_editor')) {
        // Enqueue CodeMirror CSS and JS
        wp_enqueue_style('codemirror-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css');
        wp_enqueue_script('codemirror-js', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js', array(), null, true);
        wp_enqueue_script('codemirror-python-js', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/python/python.min.js', array('codemirror-js'), null, true);

        // Enqueue the Python editor script
        wp_enqueue_script(
            'python-editor-js',
            plugin_dir_url(__FILE__) . 'js/python-editor.js',
            array('codemirror-js', 'codemirror-python-js'),
            filemtime(plugin_dir_path(__FILE__) . 'js/python-editor.js'), // Use file modification time as version
            true
        );

        // Pass Ajax URL to python-editor.js
        wp_localize_script('python-editor-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }

    // Check if the current post content contains the `python_editor_teacher_report` shortcode
    if (has_shortcode($post->post_content, 'python_editor_teacher_report')) {
        // Enqueue DataTables CSS and JS for sorting & jquery for updates
        wp_enqueue_script('jquery');
        wp_enqueue_style('datatables-css', 'https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css');
        wp_enqueue_script('datatables-js', 'https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js', array('jquery'), null, true);

        // Styling for tables
        wp_enqueue_script('datatables-buttons-js', 'https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js', array('jquery', 'datatables-js'), null, true);
        wp_enqueue_style('datatables-buttons-css', 'https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css');
        wp_enqueue_script('datatables-buttons-html5-js', 'https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js', array('datatables-buttons-js'), null, true);
        wp_enqueue_script('datatables-buttons-colvis-js', 'https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js', array('datatables-buttons-js'), null, true);

        // Enqueue the teacher report script
        wp_enqueue_script('teacher-report-tables', plugin_dir_url(__FILE__) . 'js/teacher_report_tables.js', array('jquery', 'datatables-js', 'datatables-buttons-js'), null, true);

        // Pass Ajax URL to teacher-report-tables.js
        wp_localize_script('teacher-report-tables', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }

    // Enqueue custom CSS for the editor (shared across pages)
    wp_enqueue_style('python-editor-css', plugin_dir_url(__FILE__) . 'css/editor-styles.css');
}
add_action('wp_enqueue_scripts', 'python_code_editor_enqueue_scripts');





// Include the admin report file
require_once(plugin_dir_path(__FILE__) . 'admin-reports.php');


// Register shortcode for the Python editor
function register_python_editor_shortcode() {
    add_shortcode('python_editor', 'python_code_editor_shortcode');
}
add_action('init', 'register_python_editor_shortcode');



function create_code_editor_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'python_tutorials_code';
    $charset_collate = $wpdb->get_charset_collate();

    // Create or alter the table
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Check if table exists
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;

    if (!$table_exists) {
        // Create the table if it doesn't exist
        $sql = "CREATE TABLE $table_name (
            id BIGINT(20) NOT NULL AUTO_INCREMENT,
            user_id BIGINT(20) NOT NULL,
            tutorial_id BIGINT(20) NOT NULL,
            saved_code LONGTEXT NOT NULL,
            is_complete TINYINT(1) NOT NULL DEFAULT 0,
            last_saved datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY user_tutorial (user_id, tutorial_id)
        ) $charset_collate;";
        
        dbDelta($sql);
    } else {
        // If the table exists, ensure it has the 'last_saved' column
        $columns = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'last_saved'");
        if (empty($columns)) {
            // Add 'last_saved' column if it doesn't exist
            $wpdb->query("ALTER TABLE $table_name ADD last_saved datetime DEFAULT CURRENT_TIMESTAMP NOT NULL");
        }

        // If the table exists, ensure it has the 'is_complete' column
        $columns = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'is_complete'");
        if (empty($columns)) {
            // Add 'is_complete' column if it doesn't exist
            $wpdb->query("ALTER TABLE $table_name ADD is_complete TINYINT(1) NOT NULL DEFAULT 0");
        }
    }
}


// Add admin menu for ChatGPT API settings
add_action('admin_menu', 'python_code_editor_admin_menu');
function python_code_editor_admin_menu() {
    add_menu_page(
        'Python Code Teacher Settings',
        'Python Teacher Settings',
        'manage_options',
        'python-code-editor-settings',
        'python_code_editor_settings_page',
        'dashicons-admin-generic',
        81
    );
}




// Settings page content
function python_code_editor_settings_page() {
    // Save settings if form is submitted
    if (isset($_POST['submit'])) {
        check_admin_referer('python_code_editor_settings');
        $api_key = sanitize_text_field($_POST['chatgpt_api_key']);
        update_option('python_code_editor_chatgpt_api_key', $api_key);
        echo '<div class="updated"><p>Settings saved.</p></div>';
    }

    // Get the current API key
    $api_key = get_option('python_code_editor_chatgpt_api_key', '');
    ?>
    <div class="wrap">
        <h1>Python Code Editor Settings</h1>
        <form method="post" action="">
            <?php wp_nonce_field('python_code_editor_settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">ChatGPT API Key</th>
                    <td><input type="text" name="chatgpt_api_key" value="<?php echo esc_attr($api_key); ?>" style="width: 400px;"></td>
                </tr>
            </table>
            <p>To use ChatGPT integration, you need an API key. Please follow these steps:</p>
            <ol>
                <li>Visit the <a href="https://platform.openai.com/signup" target="_blank">OpenAI Platform</a> and create an account if you don't already have one.</li>
                <li>After logging in, go to the <a href="https://platform.openai.com/account/api-keys" target="_blank">API Keys</a> section.</li>
                <li>Click on "Create new secret key" to generate a new API key.</li>
                <li>Copy the generated key and paste it into the field above.</li>
                <li>Click "Save Changes" to save your key securely.</li>
            </ol>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}







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
            $wpdb->prepare("SELECT saved_code, is_complete FROM $table_name WHERE user_id = %d AND tutorial_id = %d", $user_id, $tutorial_id)
        );

        $saved_code = $row ? $row->saved_code : '';
        $is_complete = $row ? $row->is_complete : false;
    }

    // Prepare tutorial content
    $title_text = $tutorial ? $tutorial['title'] : '';
    $challenge_text = $tutorial ? $tutorial['challenge'] : '';
    $skeleton_code = $tutorial ? $tutorial['skeleton_code'] : '';
    $example_answer = $tutorial ? $tutorial['example_answer'] : '';
    $hint_text = $tutorial ? $tutorial['hint'] : '';
    $unit_test = $tutorial ? $tutorial['unit_test'] : '';

    // Determine the initial code to load (if previously saved, student code loads, otherwise skeleton code will load)
    $initial_code = !empty($saved_code) ? $saved_code : $skeleton_code;

    // Editor HTML
    ob_start(); // Start output buffering
    ?>
    <div class="beta-container">
    <p><i>Alex & Jordan's Code Tutor feature is currently in Beta. As it's still being tested (and some extra features added), you may see some unexpected behaviour. If you do, please let me know by reporting errors <a href="https://forms.gle/VXaBkNSF2Gvv1TGAA" target="_blank">using this form</a>.</i></p>
    <p><i><strong>Currently, the code tutor does not allow the use of input() - all data must be hard coded into your program.</strong></i></p>
    
    </div>
    <div class="code-teacher-container">
        <div class="challenge-text"><h2><?php echo esc_attr($title_text); ?></h2><br/><?php echo $challenge_text; ?></div>
        <div class="editor-panel">
            <div class="editor-container">
                <div id="editor-container">
                    <div class="container-header">Your Python Code</div>
                    <div id="editor" data-tutorial-id="<?php echo esc_attr($tutorial_id); ?>" data-tutorial-code="<?php echo esc_html($initial_code); ?>"></div>
                  
                <div id="challenge-completed">
                    <!-- display none won't render when style is changed -->
                    <img src="<?php echo esc_url(plugins_url('img/complete.png', __FILE__)); ?>" alt="Challenge Completed" width="200px" <?php if(!$is_complete){ echo 'style="display:none";';} ?> >
                </div>
           
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
                <button id="reset-code">Reset Code</button>
                <div id="hint-section" style="display: none;"><strong>Hint:</strong> <?php echo $hint_text; ?></div>
                <div id="unit-test" style="display: none;"><?php echo $unit_test; ?></div>
                
            </div>
            <div id="output-section">
                <img id="helper-character" src="<?php echo esc_url(plugins_url('img/Alex_Chat_Bot_duck.png', __FILE__)); ?>" alt="Alex Help Character" style="display: none;">
                <div id="speech-bubble">Hi, it looks like you need help with your code...</div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean(); // Return the buffered content
}




// Handle AJAX request to execute code
function python_code_editor_execute_code() {
    // Get the posted code
    $code = isset($_POST['code']) ? wp_unslash($_POST['code']) : '';

    // Ensure whitespace is properly preserved
    $code = str_replace("\r\n", "\n", $code);
    $code = htmlspecialchars_decode($code, ENT_NOQUOTES);

    // Validate if the code is not empty
    if (empty(trim($code))) {
        wp_send_json_error(['message' => 'Code is required.']);
        return;
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
            'max_tokens' => 100,
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
    $is_complete = isset($_POST['is_complete']) ? intval($_POST['is_complete']) : 0;


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
            'is_complete' => $is_complete,
            'last_saved' => current_time('mysql') // current datetime
        ),
        array(
            '%d', // user_id
            '%d', // tutorial_id
            '%s',  // saved_code
            '%d',  // is_complete
            '%s'  // last_saved
        )
    );

    wp_send_json_success('Code saved successfully.');
}
add_action('wp_ajax_save_user_code', 'save_user_code');


function load_python_code_function() {
    // Get the current logged-in user ID
    $user_id = get_current_user_id();
    $tutorial_id = isset($_POST['tutorial_id']) ? intval($_POST['tutorial_id']) : null;

    // Include tutorial content from an external file
    include plugin_dir_path(__FILE__) . 'tutorials.php';

    // Select the tutorial based on the attribute
    $tutorial = isset($tutorials[$tutorial_id]) ? $tutorials[$tutorial_id] : null;
    $skeleton_code = $tutorial ? $tutorial['skeleton_code'] : '';
    

    if (!$user_id) {
        wp_send_json_error(['message' => 'Invalid request. User ID missing.']);
        return;
    }

    // Allow tutorial_id to be 0 (for the welcome tutorial)
    if ($tutorial_id === null || $tutorial_id === '') {
        wp_send_json_error(['message' => 'Invalid request. Tutorial ID missing.']);
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'python_tutorials_code';
    $row = $wpdb->get_row(
        $wpdb->prepare("SELECT saved_code, is_complete FROM $table_name WHERE user_id = %d AND tutorial_id = %d", $user_id, $tutorial_id)
    );

    if ($row) {
        wp_send_json_success(['code' => $row->saved_code, 'is_complete' => $row->is_complete]);
    } else {
        wp_send_json_success(['code' => $skeleton_code, 'is_complete' => 0]);
    }
}

add_action('wp_ajax_load_python_code', 'load_python_code_function');




// Handle AJAX request to reset user code
function reset_user_code() {
    // Get user ID and tutorial ID from the AJAX request
    $user_id = get_current_user_id();
    $tutorial_id = intval($_POST['tutorial_id']);

    if (!$user_id) {
        wp_send_json_error('User not logged in.');
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'python_tutorials_code';

    // Delete the saved code for the given user and tutorial
    $result = $wpdb->delete(
        $table_name,
        array(
            'user_id' => $user_id,
            'tutorial_id' => $tutorial_id,
        ),
        array(
            '%d',
            '%d'
        )
    );

    if ($result !== false) {
        wp_send_json_success('Code reset successfully.');
    } else {
        wp_send_json_error('Failed to reset code.');
    }
}
add_action('wp_ajax_reset_user_code', 'reset_user_code');



function python_code_editor_evaluate_code() {

    // Get the data from the request
    $tutorial_id = intval($_POST['tutorial_id']);
    $student_code = isset($_POST['code']) ? sanitize_textarea_field($_POST['code']) : '';

    if (empty($student_code)) {
        wp_send_json_error('Student code is required.');
    }


    // Get the API key from settings
    $api_key = get_option('python_code_editor_chatgpt_api_key', '');
    if (empty($api_key)) {
        wp_send_json_error('API key not set.');
    }

    

    // Include tutorial content
    include plugin_dir_path(__FILE__) . 'tutorials.php';
    $tutorial = isset($tutorials[$tutorial_id]) ? $tutorials[$tutorial_id] : null;

    if (!$tutorial) {
        wp_send_json_error('Invalid tutorial ID.');
    }

    $challenge = $tutorial['challenge'];
    $example_answer = $tutorial['example_answer'];

    // Prepare the prompt for ChatGPT
    $prompt = "This is a Python code challenge that has been set for kids aged 12 to 14: " . $challenge .
              "\nStudent's code: " . $student_code .
              "\nExample answer: " . $example_answer .
              "\nPlease show the word 'true' if all criteria have been met, and 'false' if there are still parts of the programming challenge to complete.";

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
            'max_tokens' => 10,
            'temperature' => 0.0,
        )),
        'method'  => 'POST'
    ));

    if (is_wp_error($response)) {
        wp_send_json_error('Failed to contact the API: ' . $response->get_error_message());
    }

    $response_body = wp_remote_retrieve_body($response);
    $data = json_decode($response_body, true);

    // Determine if the challenge is complete
    $is_complete = false;
    if (isset($data['choices'][0]['message']['content'])) {
        $evaluation_result = trim($data['choices'][0]['message']['content']);
        $is_complete = (strtolower($evaluation_result) === 'true');
    }

    // Return the result to JavaScript
    wp_send_json_success(['is_complete' => $is_complete]);
}
add_action('wp_ajax_evaluate_code', 'python_code_editor_evaluate_code');
add_action('wp_ajax_nopriv_evaluate_code', 'python_code_editor_evaluate_code');



?>
