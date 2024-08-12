# Test Task 1 (Simple Laravel API with Job Queue, Database, and Event Handling)

## Requirements

1. **API Endpoint:** Develop a single API endpoint #submit that accepts a `POST`
request with the following JSON payload structure: 
```json
{
  "name": "John Doe",
  "email": "john.doe@example.com",
  "message": "This is a test message"
}
```
2. Validate the data (ensure name', email and message are present).
3. **Database setup:** Use Laravel migrations to create a table named 
`submissions` with columns for `id`, `name`, `email`, `message` 
and timestamps (`creayed_at` and `updated_at`).
4. **Job Queue:** Upon receiving the API request, the data should 
not be immediately saved to the database. Instead, dispatch a Laravel job to process the data.
The job should perform the following tasks:
   1. Save the data to the `submissions` table in the database.
5. **Events:** After the data is successfully saved to the database, 
trigger a Laravel event named `SubmissionSaved`. Attach a listener to this event
that logs a message indicating a successful save, including `name` and `email` of the submission.
6. **Error handling:** Implement error handling for the API to respond with appropriate messages 
and status codes for the following scenarios:
   1. Invalid data input (e.g., missing required fields).
   2. Any errors that occur during the job processing.
7. **Documentation:** Briefly document the following in a README file:
   1. Instructions on setting up the project and running migrations.
   2. A simple explanation of how to test the API endpoint.
8. Write a simple test.
