import React, {useState, useEffect, useRef} from 'react';
import axios from 'axios';
import '../css/UserStats.css';

const StreamEventsList = () => {
    const [items, setItems] = useState([]);
    const [offset, setOffset] = useState(0);
    const [loading, setLoading] = useState(false);
    const observerRef = useRef();

    const loadMore = () => {
        if (!loading) {
            setLoading(true);
            setOffset(prevOffset => prevOffset + 100);
        }
    };

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(`http://localhost:8000/api/stream-events?offset=${offset}`);
                const newItems = response.data.items;

                if (newItems.length === 0) {
                    observerRef.current.disconnect();
                    return;
                }

                setItems(prevItems => [...prevItems, ...newItems]);
                setLoading(false);
            } catch (error) {
                console.error('Error fetching stream events:', error);
                setLoading(false);
            }
        };

        fetchData();
    }, [offset]);

    useEffect(() => {
        const options = {
            root: null,
            rootMargin: '20px',
            threshold: 1.0,
        };

        observerRef.current = new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting) {
                loadMore();
            }
        }, options);

        observerRef.current.observe(document.getElementById('observer'));
    }, []);

    return (
        <div className="stream-events-list">
            {items.map((streamEventGroup, index) => (
                <div key={index} className="event-group">
                    {streamEventGroup.map((streamEvent, eventIndex) => (
                        <div key={eventIndex} className="event">
                            <div>{streamEvent?.follower?.name} followed you!</div>
                            <div>{streamEvent?.subscriber?.name} ({streamEvent?.subscriber?.tier}) subscribed on you!
                            </div>
                            <div>{streamEvent?.donation?.follower_name} donated {streamEvent?.donation?.amount}
                                {streamEvent?.donation?.currency} to you! “{streamEvent?.donation?.message}”
                            </div>
                            <div>{streamEvent?.merchSale?.follower_name} bought some {streamEvent?.merchSale?.item_name}
                                from you for {streamEvent?.merchSale?.price} USD!
                            </div>
                        </div>
                    ))}
                </div>
            ))}
            <div id="observer"/>
        </div>
    );
};

export default StreamEventsList;
