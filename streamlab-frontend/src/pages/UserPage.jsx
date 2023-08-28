import React from 'react';
import {useLocation} from "react-router";

const UserPage = () => {

    const state = useLocation();
    const { name, success } = state.state;

    console.log(state);

    return (
        <div className="login-page">
            <h2>User Page</h2>
            <b>{name}</b>
            {success && <b> logged in</b>}
        </div>
    );
};

export default UserPage;