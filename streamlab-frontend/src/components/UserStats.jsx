import React, { useState, useEffect } from 'react';
import axios from 'axios';
import '../css/UserStats.css';

const UserStats = () => {
    const [userStats, setUserStats] = useState({});

    useEffect(() => {
        axios.get('http://localhost:8000/api/user-stats')
            .then(response => {
                setUserStats(response.data);
            })
            .catch(error => {
                console.error('Error fetching user stats:', error);
            });
    }, []);

    return (
        <div className="user-stats-container">
            <div className="user-stat">
                <h2>Total Revenue</h2>
                <p>${userStats.total_revenue}</p>
            </div>
            <div className="user-stat">
                <h2>Total Followers Gained</h2>
                <p>{userStats.total_followers_gained}</p>
            </div>
            <div className="user-stat">
                <h2>Top Items Sold</h2>
                <ul>
                    {userStats.top_items && userStats.top_items.map(item => (
                        <li key={item.item_name}>
                            {item.item_name} - ${item.total_amount}
                        </li>
                    ))}
                </ul>
            </div>
        </div>
    );
};

export default UserStats;
