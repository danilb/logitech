import React from 'react';

const LoginPage = () => {
    const handleLoginWithGoogle = () => {
        const popup = window.open('http://localhost:8000/auth/google', 'Google Login', 'width=800,height=600');

        // Listen for the result message from the popup window
        window.addEventListener('message', (event) => {
            if (event.origin === 'http://localhost:8000') {
                console.log('Received message from popup:', event.data);
                // Close the popup window
                popup.close();
            }
        });
    };

    return (
        <div className="login-page">
            <h2>Login Page</h2>
            <button onClick={handleLoginWithGoogle}>Login with Google</button>
        </div>
    );
};

export default LoginPage;