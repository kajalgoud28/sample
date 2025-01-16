# Use an official Node.js image as the base
FROM node:16

# Install PHP
RUN apt-get update && apt-get install -y php

# Set the working directory
WORKDIR /app

# Copy project files
COPY . .

# Install Node.js dependencies
RUN npm install

# Expose the port your app runs on
EXPOSE 3000

# Start the app
CMD ["node", "server.js"]
