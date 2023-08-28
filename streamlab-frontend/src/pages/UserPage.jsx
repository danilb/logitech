import React from 'react';
import {useLocation} from "react-router";
import UserStats from "../components/UserStats";
import '../css/UserStats.css';
import StreamEventsList from "../components/StreamEventsList";

const UserPage = () => {

    const state = useLocation();
    const {name, success} = state.state;

    console.log(state);

    return (
        <>
            <div className="header">
                <h2>User Page</h2>
                <b>{name}</b>
            </div>
            <UserStats/>
            <StreamEventsList />
        </>
    );
};

export default UserPage;