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
            rootMargin: '100px',
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
                    <div className="event">
                        <div>{streamEventGroup[0]?.follower?.name} followed you!</div>
                        <div>{streamEventGroup[1].subscriber?.name} ({streamEventGroup[1]?.subscriber?.tier}) subscribed on you!
                        </div>
                        <div>{streamEventGroup[2]?.donation?.follower_name} donated {streamEventGroup[2]?.donation?.amount}
                            {streamEventGroup[2]?.donation?.currency} to you! “{streamEventGroup[2]?.donation?.message}”
                        </div>
                        <div>{streamEventGroup[3]?.merchSale?.follower_name} bought some {streamEventGroup[3]?.merchSale?.item_name}
                            from you for {streamEventGroup[3]?.merchSale?.price} USD!
                        </div>
                    </div>
                </div>
            ))}
            <div id="observer"/>
        </div>
    );
};

export default StreamEventsList;
