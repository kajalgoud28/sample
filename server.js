const express = require('express');
const { exec } = require('child_process');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;

// Serve PHP files by invoking the PHP CLI
app.get('/', (req, res) => {
  const phpFilePath = path.join(__dirname, 'index.php');
  
  console.log(`Attempting to execute PHP file at: ${phpFilePath}`);

  exec(`php ${phpFilePath}`, (error, stdout, stderr) => {
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
    res.send(stdout);
  });
});

// Start the server
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
