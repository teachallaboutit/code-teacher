<?php
/*
Plugin Name: TeachAllAboutIt - SEN Friendly Code Teacher for Python
Description: An embeddable Python code editor to help students learn Python, with hints and SEN-friendly features.
Version: 1.0
Author: Holly Billinghurst
*/

// Register shortcode to embed the Python editor
defined('ABSPATH') or die("You can't access this file directly.");

function python_code_editor_enqueue_scripts() {
    // Enqueue CodeMirror CSS and JS
    wp_enqueue_style('codemirror-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css');
    wp_enqueue_script('codemirror-js', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js', array(), null, true);
    wp_enqueue_script('codemirror-python-js', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/python/python.min.js', array('codemirror-js'), null, true);
    // Enqueue custom CSS and JavaScript for plugin functionality
    wp_enqueue_style('python-editor-css', plugin_dir_url(__FILE__) . 'css/editor-styles.css');
    // Enqueue custom JavaScript for plugin functionality with cache-busting version
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

    // Define the tutorial code
    $example_code_snippets = array(
        "print('Hello, World!')",
        "for i in range(5):\n    print(i)",
        "name = input('What is your name? ')\nprint('Hello, ' + name + '!')"
    );

    $tutorial_code = isset($example_code_snippets[$atts['tutorial']]) ? $example_code_snippets[$atts['tutorial']] : "";

    // Editor HTML
    ob_start(); // Start output buffering
    ?>
    <div class="editor-container">
        <div id="editor-container">
            <div class="container-header">Python Code - Sandbox</div>
            <div id="editor" class="CodeMirror" data-tutorial-code="<?php echo esc_attr($tutorial_code); ?>"></div>
        </div>
        <div id="output-container">
            <div class="container-header">Your Code Output</div>
            <pre id="output"></pre>
            <input type="text" id="user-input" style="margin-top: 10px; width: 95%; padding: 5px; font-size: 16px; background-color: #ffffff; color: #000000;" placeholder="Enter input here..." />
        </div>
    </div>
    
    <div id="editor-controls">
		<button id="run-code">Run Code</button>
        <button id="help-button">Help</button>
    </div>
    <div id="output-section">
        <img id="helper-character" src="<?php echo esc_url(plugins_url('img/Alex_Chat_Bot.png', __FILE__)); ?>" alt="Alex Help Character" style="display: none;">
        <div id="speech-bubble">Hi, it looks like you need help with your code...</div>
    </div>
    <?php
    return ob_get_clean(); // Return the buffered content
}
add_shortcode('python_editor', 'python_code_editor_shortcode');

// Handle AJAX request to execute code
function python_code_editor_execute_code() {
    $code = isset($_POST['code']) ? sanitize_textarea_field($_POST['code']) : '';

    if (empty($code)) {
        wp_send_json_error('Code is required.');
    }

    $api_url = 'https://teachallaboutit.pythonanywhere.com/api/execute';

    // Ensure code is properly JSON encoded
    $response = wp_remote_post($api_url, array(
        'headers' => array('Content-Type' => 'application/json'),
        'body'    => json_encode(array(
            'code' => $code,
        )),
        'method'  => 'POST',
        'data_format' => 'body'
    ));

    if (is_wp_error($response)) {
        wp_send_json_error('Failed to contact the API: ' . $response->get_error_message());
    }

    $response_body = wp_remote_retrieve_body($response);
    $data = json_decode($response_body, true);

    if ($data && isset($data['success']) && $data['success']) {
        wp_send_json_success($data);
    } else {
        $error_message = isset($data['output']) ? $data['output'] : 'Unexpected response format from the API.';
        wp_send_json_error($error_message);
    }
}
add_action('wp_ajax_execute_code', 'python_code_editor_execute_code');
add_action('wp_ajax_nopriv_execute_code', 'python_code_editor_execute_code');
