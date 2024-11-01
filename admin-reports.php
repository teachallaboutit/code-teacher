<?php

function create_feedback_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'python_feedback';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        tutorial_id mediumint(9) NOT NULL,
        feedback_text text NOT NULL,
        feedback_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

register_activation_hook(__FILE__, 'create_feedback_table');


// for styling teacher report code
function enqueue_prismjs() {
    wp_enqueue_style('prismjs-css', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/themes/prism.min.css');
    wp_enqueue_script('prismjs-js', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/prism.min.js', array(), null, true);
    wp_enqueue_script('prismjs-python-js', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/components/prism-python.min.js', array('prismjs-js'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_prismjs');



// Function for generating the teacher report

function generate_teacher_report() {
    if (!current_user_can('administrator')) {
        return "This page is restricted to administrators and tutors";
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'python_tutorials_code'; // This is the table storing the saved data

    // Check if feedback table exists and create it if not
    $feedback_table = $wpdb->prefix . 'python_feedback';
    if ($wpdb->get_var("SHOW TABLES LIKE '$feedback_table'") != $feedback_table) {
        create_feedback_table();
    }

    // Include tutorial content from an external file
    include plugin_dir_path(__FILE__) . 'tutorials.php';

    // Fetch all unique user IDs from the saved data table
    $user_ids = $wpdb->get_col("SELECT DISTINCT user_id FROM $table_name");

    if (empty($user_ids)) {
        return "No user data available.";
    }

    // Fetch user data ordered by last name, then first name
    $user_data = [];
    foreach ($user_ids as $user_id) {
        $user_info = get_userdata($user_id);
        if ($user_info) {
            $user_data[] = [
                'user_id' => $user_id,
                'first_name' => $user_info->user_firstname,
                'last_name' => $user_info->user_lastname,
                'username' => $user_info->user_login,
            ];
        }
    }

    // Sort users by last name, then first name
    usort($user_data, function ($a, $b) {
        $last_name_comparison = strcasecmp($a['last_name'], $b['last_name']);
        if ($last_name_comparison === 0) {
            return strcasecmp($a['first_name'], $b['first_name']);
        }
        return $last_name_comparison;
    });

    // Fetch data for the selected user
    $selected_user = isset($_GET['user_id']) ? intval($_GET['user_id']) : $user_data[0]['user_id'];
    $user_code_data = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT tutorial_id, is_complete, last_saved FROM $table_name WHERE user_id = %d",
            $selected_user
        ),
        ARRAY_A
    );

    // Get user information for the title
    $selected_user_info = get_userdata($selected_user);
    $username = $selected_user_info->user_firstname . ' ' . $selected_user_info->user_lastname;

    // Dropdown to select users
    $output = '<form method="GET" action="">
                <label for="user_id">Select User to see their code:</label>
                <select name="user_id" id="user_id" onchange="this.form.submit()">';

    foreach ($user_data as $user) {
        $selected = ($user['user_id'] == $selected_user) ? 'selected' : '';
        $user_display_name = trim($user['first_name'] . ' ' . $user['last_name']);
        $output .= sprintf(
            '<option value="%d" %s>%s</option>',
            esc_attr($user['user_id']),
            esc_attr($selected),
            esc_html($user_display_name)
        );
    }

    $output .= '</select></form><br>'; // Close the form and add a line break

    $output .= '<h2>Programming Practice Completed by ' . esc_html($username) . '</h2>';

    // Display the report table
    $output .= '<table id="teacher-report-table" class="teacher-report-table">
                <thead>
                    <tr>
                        <th>Tutorial Title</th>
                        <th>Completed</th>
                        <th>Last Saved</th>
                    </tr>
                </thead>
                <tbody>';

    foreach ($user_code_data as $data) {
        $tutorial_id = $data['tutorial_id'];
        $tutorial_title = isset($tutorials[$tutorial_id]['title']) ? $tutorials[$tutorial_id]['title'] : 'Unknown';

        $output .= sprintf(
            '<tr>
                <td><a href="#" class="expand-code-editor" data-tutorial-id="%d" data-user-id="%d">%s</a></td>
                <td>%s</td>
                <td>%s</td>
            </tr>',
            esc_attr($tutorial_id),
            esc_attr($selected_user),
            esc_html($tutorial_title . ' (id=' . $tutorial_id . ')'),
            esc_html($data['is_complete'] ? 'Yes' : 'No'),
            esc_html($data['last_saved'] ? date('d/m/Y g:i A', strtotime($data['last_saved'])) : 'Not Saved')
        );
    }

    $output .= '</tbody></table>';

    // Add script to include teacher_report_tables.js
    $output .= '<script type="text/javascript" src="' . plugin_dir_url(__FILE__) . 'js/teacher_report_tables.js"></script>';

    return $output;
}

// Add shortcode for admin view report
add_shortcode('python_editor_teacher_report', 'generate_teacher_report');


function load_student_python_code() {
    // Verify current user is logged in and has appropriate permissions
    if (!current_user_can('administrator') && !current_user_can('tutor')) {
        wp_send_json_error(['message' => 'Unauthorized request.']);
        return;
    }

    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $tutorial_id = isset($_POST['tutorial_id']) ? intval($_POST['tutorial_id']) : 0;

    if (!$user_id || !$tutorial_id) {
        wp_send_json_error(['message' => 'Invalid request. User ID or Tutorial ID missing.']);
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'python_tutorials_code';
    $row = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT saved_code FROM $table_name WHERE user_id = %d AND tutorial_id = %d",
            $user_id,
            $tutorial_id
        )
    );

    // Include tutorial content
    include plugin_dir_path(__FILE__) . 'tutorials.php';

    $challenge_text = isset($tutorials[$tutorial_id]['challenge']) ? $tutorials[$tutorial_id]['challenge'] : 'Challenge details not found.';

    if ($row) {
        wp_send_json_success(['code' => $row->saved_code, 'challenge' => $challenge_text]);
    } else {
        wp_send_json_success(['code' => '', 'challenge' => $challenge_text]);
    }
}
add_action('wp_ajax_load_student_python_code', 'load_student_python_code');


// Function to save student feedback
function save_student_feedback() {
    if (!current_user_can('administrator') && !current_user_can('tutor')) {
        wp_send_json_error(['message' => 'Unauthorized request.']);
        return;
    }

    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $tutorial_id = isset($_POST['tutorial_id']) ? intval($_POST['tutorial_id']) : 0;
    $feedback_text = isset($_POST['feedback']) ? sanitize_textarea_field($_POST['feedback']) : '';

    if (!$user_id || !$tutorial_id || empty($feedback_text)) {
        wp_send_json_error(['message' => 'Invalid request. Missing required data: User ID, Tutorial ID, or Feedback text.']);
        return;
    }

    // Get current logged-in user's username
    $current_user = wp_get_current_user();
    if (!$current_user->exists()) {
        wp_send_json_error(['message' => 'Unable to identify current user.']);
        return;
    }
    $tutor_first_name = $current_user->user_firstname;
    $tutor_last_name = $current_user->user_lastname;
    $tutor_full_name = trim($tutor_first_name . ' ' . $tutor_last_name);

    // Append the tutor's name to the feedback
    $feedback_text_with_tutor = $feedback_text . ' (' . $tutor_full_name . ')';

    global $wpdb;
    $table_name = $wpdb->prefix . 'python_feedback';

    // Insert feedback into the database
    $result = $wpdb->insert(
        $table_name,
        [
            'user_id' => $user_id,
            'tutorial_id' => $tutorial_id,
            'feedback_text' => $feedback_text_with_tutor,
            'feedback_date' => current_time('mysql')
        ],
        ['%d', '%d', '%s', '%s']
    );

    // Check the result and provide more detailed error messages
    if ($result) {
        wp_send_json_success([
            'feedback' => esc_html($feedback_text_with_tutor),
            'date' => date('d/m/Y g:i A', strtotime(current_time('mysql'))),
            'feedback_id' => $wpdb->insert_id // Return the inserted feedback ID for further edits
        ]);
    } else {
        // Check if the table exists
        if ($wpdb->last_error) {
            wp_send_json_error([
                'message' => 'Database error: ' . $wpdb->last_error
            ]);
        } else {
            wp_send_json_error([
                'message' => 'Failed to save feedback. Please verify the database table exists.'
            ]);
        }
    }
}
add_action('wp_ajax_save_student_feedback', 'save_student_feedback');


// Function to load student feedback
function load_student_feedback() {
    if (!current_user_can('administrator') && !current_user_can('tutor')) {
        wp_send_json_error(['message' => 'Unauthorized request.']);
        return;
    }

    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $tutorial_id = isset($_POST['tutorial_id']) ? intval($_POST['tutorial_id']) : 0;

    if (!$user_id || !$tutorial_id) {
        wp_send_json_error(['message' => 'Invalid request. User ID or Tutorial ID missing.']);
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'python_feedback';
    $rows = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT feedback_text, feedback_date FROM $table_name WHERE user_id = %d AND tutorial_id = %d ORDER BY feedback_date DESC",
            $user_id,
            $tutorial_id
        ),
        ARRAY_A
    );

    if ($rows) {
        $feedback_data = array_map(function($row) {
            return [
                'id' => $row['id'], // feedback ID included for editing
                'text' => esc_html($row['feedback_text']),
                'date' => date('d/m/Y g:i A', strtotime($row['feedback_date']))
            ];
        }, $rows);
        
        wp_send_json_success(['feedback' => $feedback_data]);
    } else {
        wp_send_json_success(['feedback' => []]);
    }
}
add_action('wp_ajax_load_student_feedback', 'load_student_feedback');


// Function to update student feedback
function update_student_feedback() {
    if (!current_user_can('administrator') && !current_user_can('tutor')) {
        wp_send_json_error(['message' => 'Unauthorized request.']);
        return;
    }

    $feedback_id = isset($_POST['feedback_id']) ? intval($_POST['feedback_id']) : 0;
    $tutorial_id = isset($_POST['tutorial_id']) ? intval($_POST['tutorial_id']) : 0;
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $feedback_text = isset($_POST['feedback']) ? sanitize_textarea_field($_POST['feedback']) : '';

    if (!$feedback_id){
        wp_send_json_error(['message' => 'Invalid request. Missing Feedback Id.']);
        return;   
    } 
    else if(!$tutorial_id){
        wp_send_json_error(['message' => 'Invalid request. Missing Tutorial Id.']);
        return;   
    }
    else if(!$user_id ){
        wp_send_json_error(['message' => 'Invalid request. Missing User Id.']);
        return;   
    }
    else if(empty($feedback_text)){
        wp_send_json_error(['message' => 'Invalid request. Feedback Text is empty.']);
        return;   
    }  

    global $wpdb;
    $table_name = $wpdb->prefix . 'python_feedback';

    // Update feedback in the database
    $result = $wpdb->update(
        $table_name,
        [
            'feedback_text' => $feedback_text,
            'feedback_date' => current_time('mysql')
        ],
        [
            'id' => $feedback_id,
            'user_id' => $user_id,
            'tutorial_id' => $tutorial_id
        ],
        ['%s', '%s'],
        ['%d', '%d', '%d']
    );

    if ($result !== false) {
        wp_send_json_success([
            'feedback' => esc_html($feedback_text),
            'date' => date('d/m/Y g:i A', strtotime(current_time('mysql')))
        ]);
    } else {
        // Check if there is an error with the query
        if ($wpdb->last_error) {
            wp_send_json_error(['message' => 'Database error: ' . $wpdb->last_error]);
        } else {
            wp_send_json_error(['message' => 'Failed to update feedback.']);
        }
    }
}
add_action('wp_ajax_update_student_feedback', 'update_student_feedback');

?>
