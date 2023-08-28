const LoginPage = () => {
    const handleLoginWithGoogle = () => {
        window.location.href = 'http://localhost:8000/auth/google';
    };

    return (
        <div className="login-page">
            <h2>Login Page</h2>
            <button onClick={handleLoginWithGoogle}>Login with Google</button>
        </div>
    );
};

export default LoginPage;