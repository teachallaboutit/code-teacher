document.addEventListener('DOMContentLoaded', function () {
    const tableElement = document.querySelector('#teacher-report-table');

    if (tableElement && !jQuery.fn.DataTable.isDataTable(tableElement)) {
        // Initialize DataTables on the teacher-report-table
        jQuery(tableElement).DataTable({
            "paging": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "order": [[0, "asc"]], // Default sort by Tutorial ID
            "columnDefs": [
                { "orderable": true, "targets": [0, 1, 2] },
                { "className": "dt-center", "targets": [0, 1, 2] } // Center-align all columns
            ],
            "dom": 'Bfrtip', // Add buttons to the DataTable
            "buttons": [
                {
                    extend: 'colvis',
                    text: 'Filter Columns'
                }
            ],
            "createdRow": function (row, data, dataIndex) {
                // If the "Completed" column (index 1) is "Yes", color the cell green
                if (data[1] === 'Yes') {
                    jQuery('td:eq(1)', row).css('background-color', '#cbf7dc');
                }
            }
        });

        // Handle click event on Tutorial Title to expand and show/hide saved code
        jQuery(tableElement).off('click', 'a.expand-code-editor').on('click', 'a.expand-code-editor', function (e) {
            e.preventDefault();

            const tutorialId = jQuery(this).data('tutorial-id');
            const userId = jQuery(this).data('user-id');
            const row = jQuery(this).closest('tr');
            const editorRow = row.next('.code-editor-row');

            // If editor is already visible, remove it
            if (editorRow.length) {
                editorRow.remove();
            } else {
                // Make an AJAX request to load saved code and challenge
                jQuery.ajax({
                    url: ajax_object.ajax_url,
                    method: 'POST',
                    data: {
                        action: 'load_student_python_code',
                        tutorial_id: tutorialId,
                        user_id: userId
                    },
                    success: function (response) {
                        if (response.success) {
                            // Add a new row to show the challenge and saved code
                            const challengeHtml = `
                                <div class="challenge-section">
                                    <button class="toggle-challenge">Show Challenge</button>
                                    <div class="challenge-content" style="display: none;">
                                        ${response.data.challenge}
                                    </div>
                                </div>`;

                            const codeRowHtml = `
                                <tr class="code-editor-row">
                                    <td colspan="3">
                                        ${challengeHtml}
                                        <pre><code class="language-python">${response.data.code}</code></pre>
                                        <div class="feedback-section">
                                            <br/>
                                            <h4>Provide Feedback</h4>
                                            <textarea class="feedback-input" rows="3" placeholder="Write your feedback here..."></textarea>
                                            <button class="submit-feedback" data-tutorial-id="${tutorialId}" data-user-id="${userId}">Submit Feedback</button>
                                            <div class="feedback-list">
                                                <br/>
                                                <h4>Previous Feedback:</h4>
                                                <ul class="feedback-items"></ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>`;
                            row.after(codeRowHtml);

                            // Trigger syntax highlighting if Prism.js is loaded
                            if (typeof Prism !== 'undefined') {
                                Prism.highlightAll();
                            }

                            // Load previous feedback if any
                            loadPreviousFeedback(tutorialId, userId, row.next('.code-editor-row').find('.feedback-items'));

                            // Handle toggle of the challenge section
                            jQuery('.toggle-challenge').off('click').on('click', function () {
                                const challengeContent = jQuery(this).next('.challenge-content');
                                if (challengeContent.is(':visible')) {
                                    challengeContent.slideUp();
                                    jQuery(this).text('Show Challenge');
                                } else {
                                    challengeContent.slideDown();
                                    jQuery(this).text('Hide Challenge');
                                }
                            });
                        } else {
                            alert('Failed to load saved code.');
                        }
                    },
                    error: function () {
                        alert('Error loading saved code. Please try again.');
                    }
                });
            }
        });

        // Handle feedback submission
        jQuery(tableElement).off('click', '.submit-feedback').on('click', '.submit-feedback', function () {
            const tutorialId = jQuery(this).data('tutorial-id');
            const userId = jQuery(this).data('user-id');
            const feedbackInput = jQuery(this).prev('.feedback-input');
            const feedbackText = feedbackInput.val().trim();

            if (feedbackText) {
                // Make an AJAX request to save feedback
                jQuery.ajax({
                    url: ajax_object.ajax_url,
                    method: 'POST',
                    data: {
                        action: 'save_student_feedback',
                        tutorial_id: tutorialId,
                        user_id: userId,
                        feedback: feedbackText
                    },
                    success: function (response) {
                        if (response.success) {
                            // Add the new feedback to the list with an edit link
                            const feedbackList = feedbackInput.closest('.feedback-section').find('.feedback-items');
                            feedbackList.prepend(`<li>${response.data.feedback} - <small>${response.data.date}</small> <a href="#" class="edit-feedback" data-feedback-id="${response.data.feedback_id}" data-tutorial-id="${tutorialId}" data-user-id="${userId}">Edit</a></li>`);
                            feedbackInput.val('');
                        } else {
                            alert(response.data.message || 'Failed to save feedback.');
                        }
                    },
                    error: function () {
                        alert('Error saving feedback. Please try again.');
                    }
                });
            } else {
                alert('Please enter some feedback before submitting.');
            }
        });

        // Handle click event to edit feedback
        jQuery(tableElement).off('click', '.edit-feedback').on('click', '.edit-feedback', function (e) {
            e.preventDefault();
            const feedbackId = jQuery(this).data('feedback-id');
            const tutorialId = jQuery(this).data('tutorial-id');
            const userId = jQuery(this).data('user-id');
            const feedbackItem = jQuery(this).closest('li');
            const feedbackText = feedbackItem.text().split(' - ')[0].trim();

            // Load the feedback text into the feedback input for editing
            const feedbackInput = feedbackItem.closest('.feedback-section').find('.feedback-input');
            feedbackInput.val(feedbackText);

            // Change the submit button to an update button
            const submitButton = feedbackItem.closest('.feedback-section').find('.submit-feedback');
            submitButton.text('Update Feedback').addClass('update-feedback').removeClass('submit-feedback').data('feedback-id', feedbackId);
        });

        // Handle feedback update
        jQuery(tableElement).off('click', '.update-feedback').on('click', '.update-feedback', function () {
            const feedbackId = jQuery(this).data('feedback-id');
            const tutorialId = jQuery(this).data('tutorial-id');
            const userId = jQuery(this).data('user-id');
            const feedbackInput = jQuery(this).prev('.feedback-input');
            const feedbackText = feedbackInput.val().trim();

            if (feedbackText) {
                // Make an AJAX request to update feedback
                jQuery.ajax({
                    url: ajax_object.ajax_url,
                    method: 'POST',
                    data: {
                        action: 'update_student_feedback',
                        feedback_id: feedbackId,
                        tutorial_id: tutorialId,
                        user_id: userId,
                        feedback: feedbackText
                    },
                    success: function (response) {
                        if (response.success) {
                            // Update the feedback item in the list
                            const feedbackItem = feedbackInput.closest('.feedback-section').find(`a.edit-feedback[data-feedback-id="${feedbackId}"]`).closest('li');
                            feedbackItem.html(`${response.data.feedback} - <small>${response.data.date}</small> <a href="#" class="edit-feedback" data-feedback-id="${feedbackId}" data-tutorial-id="${tutorialId}" data-user-id="${userId}">Edit</a>`);
                            feedbackInput.val('');

                            // Change the update button back to a submit button
                            const updateButton = feedbackInput.closest('.feedback-section').find('.update-feedback');
                            updateButton.text('Submit Feedback').addClass('submit-feedback').removeClass('update-feedback').removeData('feedback-id');
                        } else {
                            alert(response.data.message || 'Failed to update feedback.');
                        }
                    },
                    error: function () {
                        alert('Error updating feedback. Please try again.');
                    }
                });
            } else {
                alert('Please enter some feedback before updating.');
            }
        });
    }

    // Function to load previous feedback
    function loadPreviousFeedback(tutorialId, userId, feedbackListElement) {
        jQuery.ajax({
            url: ajax_object.ajax_url,
            method: 'POST',
            data: {
                action: 'load_student_feedback',
                tutorial_id: tutorialId,
                user_id: userId
            },
            success: function (response) {
                if (response.success) {
                    const feedbackItems = response.data.feedback;
                    feedbackItems.forEach(feedback => {
                        feedbackListElement.append(`<li>${feedback.text} - <small>${feedback.date} <a href="#" class="edit-feedback" data-feedback-id="${feedback.id}" data-tutorial-id="${tutorialId}" data-user-id="${userId}">Edit</a></small></li>`);
                    });
                }
            },
            error: function () {
                console.error('Error loading feedback.');
            }
        });
    }
});
