import React from 'react';
import {useNavigate} from "react-router";

const LoginPage = () => {

    const navigate = useNavigate();

    const handleLoginWithGoogle = () => {
        const popup = window.open('http://localhost:8000/auth/google', 'Google Login', 'width=800,height=600');

        // Listen for the result message from the popup window
        window.addEventListener('message', (event) => {
            if (event.origin === 'http://localhost:8000') {
                console.log('Received message from popup:', event.data);
                // Close the popup window
                popup.close();
                navigate('/userpage', { state: { name: event.data.name, success: event.data.success } });
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