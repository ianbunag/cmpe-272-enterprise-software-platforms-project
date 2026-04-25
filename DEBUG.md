# Debugging Guide

*Estimated read time: 3 minutes*

## PhpStorm

### Create Server Configuration

1. Go to **Settings > PHP > Servers**.
2. Click the **+** icon to add a new server.
3. Configure the server:
   - **Name**: Any name
   - **Host**: `localhost`
   - **Port**: The HTTP_PORT you configured locally (e.g., `8080`)
   - **Debugger**: Select `Xdebug`.
   - **Use path mappings**: Check this box and map the project directory to the server's document root (`/var/www/html`).
4. Click **OK** to save the server configuration.

### Start Debugging

1. Install Xdebug Helper in your browser (available for Chrome and Safari).
2. In your browser, navigate to your application.
3. Toggle the Xdebug Helper extension icon to start a debugging session.
4. Click the **Start Listening for PHP Debug Connections** button in PhpStorm (the phone icon in the toolbar).
5. Set breakpoints in your PHP code by clicking in the left gutter next to the line numbers.
6. Interact with your application in the browser to trigger the code execution. PhpStorm will pause at the breakpoints, allowing you to inspect variables, step through code, and analyze the execution flow.