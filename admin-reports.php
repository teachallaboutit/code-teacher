<?php
// Function for generating the teacher report

function generate_teacher_report() {
    if (!current_user_can('administrator')) {
        return "This page is restricted to administrators and tutors";
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'python_tutorials_code'; // Assuming this is the table storing the saved data

    // Include tutorial content from an external file
    include plugin_dir_path(__FILE__) . 'tutorials.php';

    // Fetch all unique usernames with saved data
    $users = $wpdb->get_results(
        "SELECT DISTINCT user_id FROM $table_name",
        ARRAY_A
    );

    if (empty($users)) {
        return "No user data available.";
    }

    // Fetch user data to display
    $selected_user = isset($_GET['user_id']) ? intval($_GET['user_id']) : $users[0]['user_id'];
    $user_data = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT tutorial_id, is_complete, last_saved FROM $table_name WHERE user_id = %d",
            $selected_user
        ),
        ARRAY_A
    );

    // Get user information for the title
    $user_info = get_userdata($selected_user);
    $username = $user_info->user_firstname . ' ' . $user_info->user_lastname;

    // Dropdown to select users
    $output = '<form method="GET" action="">
                <label for="user_id">Select User:</label>
                <select name="user_id" id="user_id" onchange="this.form.submit()">';

    foreach ($users as $user) {
        $user_info = get_userdata($user['user_id']);
        $selected = ($user['user_id'] == $selected_user) ? 'selected' : '';
        $output .= sprintf(
            '<option value="%d" %s>%s</option>',
            esc_attr($user['user_id']),
            esc_attr($selected),
            esc_html($user_info->user_login)
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

    foreach ($user_data as $data) {
        $tutorial_id = $data['tutorial_id'];
        $tutorial_title = isset($tutorials[$tutorial_id]['title']) ? $tutorials[$tutorial_id]['title'] : 'Unknown';

        $output .= sprintf(
            '<tr>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            </tr>',
            esc_html($tutorial_title . '   (id=' . $tutorial_id . ')'),
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
?>
