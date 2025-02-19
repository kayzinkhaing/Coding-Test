/* Questions 
Let's say you're developing a security system where:

A user must provide a correct username and password.
The user must pass a second security check (e.g., a CAPTCHA).
The user’s account must be active (not suspended).
If the user is an administrator, they should be granted full access,
but a regular user should only have limited access. */

function getUserInfo(username) {
    // Simulate retrieving user info from a database or external system
    const users = {
      'user123': { password: 'password123', isActive: true, isAdmin: false },
      'admin123': { password: 'adminpass123', isActive: true, isAdmin: true },
    };
  
    return users[username] || null;  // Returns null if user doesn't exist
  }
  
  function login(username, password, isCaptchaValid) {
    // Get user info from database
    const userInfo = getUserInfo(username);
  
    if (!userInfo || userInfo.password !== password) {
      console.log('Invalid credentials.');
      return;
    }
    console.log('Credentials are valid.');
  
    // Check CAPTCHA
    if (!isCaptchaValid) {
      console.log('CAPTCHA failed.');
      return;
    }
    console.log('CAPTCHA passed.');
  
    // Check account status
    if (!userInfo.isActive) {
      console.log('Account is suspended.');
      return;
    }
    console.log('Account is active.');
  
    // Grant access based on admin status
    if (userInfo.isAdmin) {
      console.log('Welcome, Admin! You have full access.');
    } else {
      console.log('Welcome, User! You have limited access.');
    }
  }
  
  // Test cases
  login('user123', 'password123', true); // Welcome, User! You have limited access.
  login('admin123', 'adminpass123', true); // Welcome, Admin! You have full access.
  login('user123', 'wrongpassword', true); // Invalid credentials.
  login('user123', 'password123', false); // CAPTCHA failed.