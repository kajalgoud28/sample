const express = require('express');  // Import the express module
const { exec } = require('child_process');  // Import exec from child_process for executing commands
const path = require('path');  // Import path module for file path handling

const app = express();
const PORT = process.env.PORT || 3000;  // Define the port to listen on (either from the environment or 3000)

// Serve PHP files by invoking the PHP CLI
app.get('/', (req, res) => {
  const phpFilePath = path.join(__dirname, 'index.php');  // Define path to PHP file

  console.log(`Attempting to execute PHP file at: ${phpFilePath}`);  // Log file path for debugging

  exec(`php ${phpFilePath}`, (error, stdout, stderr) => {  // Execute PHP script
    if (error) {
      console.error(`Error executing PHP file: ${error.message}`);
      res.status(500).send(`Internal Server Error: ${error.message}`);
      return;
    }
    if (stderr) {
      console.error(`PHP Error: ${stderr}`);
      res.status(500).send(`PHP Error: ${stderr}`);
      return;
    }
    res.send(stdout);  // Send the output of the PHP script as the response
  });
});

// Start the server
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
