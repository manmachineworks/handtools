<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dealer & Online Shop Locator</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #1a2a6c);
            color: #333;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            padding: 30px 20px;
            color: white;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            z-index: -1;
        }

        header h1 {
            font-size: 2.8rem;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        header p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            opacity: 0.9;
        }

        .search-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }

        .search-box {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .search-input {
            flex: 1;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #1a73e8;
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
        }

        .search-btn {
            background: linear-gradient(to right, #1a73e8, #0d47a1);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.4);
        }

        .filter-section {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 15px;
        }

        .filter-btn {
            background: #f0f0f0;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .filter-btn.active {
            background: linear-gradient(to right, #1a73e8, #0d47a1);
            color: white;
        }

        .filter-btn:hover:not(.active) {
            background: #e0e0e0;
        }

        .content-section {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .map-container {
            flex: 1;
            min-width: 300px;
            height: 500px;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        #map {
            width: 100%;
            height: 100%;
            border-radius: 15px;
        }

        .results-container {
            flex: 1;
            min-width: 300px;
            max-height: 500px;
            overflow-y: auto;
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .results-header h2 {
            font-size: 1.8rem;
            color: #1a2a6c;
        }

        .results-count {
            background: #f0f0f0;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .result-card {
            display: flex;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            background: #f9f9f9;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: #1a73e8;
        }

        .result-card.active {
            border-color: #1a73e8;
            background: #e8f0fe;
        }

        .result-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(to right, #1a73e8, #0d47a1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .result-details {
            flex: 1;
        }

        .result-details h3 {
            font-size: 1.3rem;
            margin-bottom: 5px;
            color: #1a2a6c;
        }

        .result-type {
            display: inline-block;
            background: #e8f0fe;
            color: #1a73e8;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-bottom: 10px;
        }

        .result-address, .result-phone, .result-hours {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
            color: #555;
            font-size: 0.95rem;
        }

        .result-address i, .result-phone i, .result-hours i {
            margin-right: 8px;
            color: #1a73e8;
        }

        .online-shops {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 40px;
        }

        .online-shops h2 {
            font-size: 1.8rem;
            color: #1a2a6c;
            margin-bottom: 25px;
        }

        .shops-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
        }

        .shop-card {
            background: #f9f9f9;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .shop-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .shop-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(to right, #1a73e8, #0d47a1);
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
        }

        .shop-card h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #1a2a6c;
        }

        .shop-card p {
            color: #555;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .visit-btn {
            display: inline-block;
            background: linear-gradient(to right, #1a73e8, #0d47a1);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .visit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.4);
        }

        footer {
            text-align: center;
            color: white;
            padding: 20px;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .content-section {
                flex-direction: column;
            }
            
            .map-container, .results-container {
                width: 100%;
                min-width: auto;
            }
            
            .search-box {
                flex-direction: column;
            }
            
            .search-btn {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Dealer & Online Shop Locator</h1>
            <p>Find authorized dealers near you or browse our trusted online partners</p>
        </header>
        
        <section class="search-section">
            <div class="search-box">
                <input type="text" class="search-input" id="location-input" placeholder="Enter your city, zip code, or address">
                <button class="search-btn" id="search-btn">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
            
            <div class="filter-section">
                <button class="filter-btn active" data-filter="all">All Dealers</button>
                <button class="filter-btn" data-filter="premium">Premium Dealers</button>
                <button class="filter-btn" data-filter="authorized">Authorized Dealers</button>
                <button class="filter-btn" data-filter="service">Service Centers</button>
            </div>
        </section>
        
        <section class="content-section">
            <div class="map-container">
                <div id="map"></div>
            </div>
            
            <div class="results-container">
                <div class="results-header">
                    <h2>Local Dealers</h2>
                    <span class="results-count">8 results</span>
                </div>
                
                <div id="results-list">
                    <!-- Results will be populated by JavaScript -->
                </div>
            </div>
        </section>
        
        <section class="online-shops">
            <h2>Online Shops</h2>
            <div class="shops-grid">
                <div class="shop-card">
                    <div class="shop-logo">
                        <i class="fab fa-amazon"></i>
                    </div>
                    <h3>Amazon Store</h3>
                    <p>Official products with fast shipping</p>
                    <a href="#" class="visit-btn">Visit Shop</a>
                </div>
                
                <div class="shop-card">
                    <div class="shop-logo">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>Official Web Store</h3>
                    <p>Full product catalog with exclusive deals</p>
                    <a href="#" class="visit-btn">Visit Shop</a>
                </div>
                
                <div class="shop-card">
                    <div class="shop-logo">
                        <i class="fab fa-ebay"></i>
                    </div>
                    <h3>eBay Marketplace</h3>
                    <p>New and refurbished items</p>
                    <a href="#" class="visit-btn">Visit Shop</a>
                </div>
                
                <div class="shop-card">
                    <div class="shop-logo">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3>Electronics Pro</h3>
                    <p>Specialized electronics retailer</p>
                    <a href="#" class="visit-btn">Visit Shop</a>
                </div>
            </div>
        </section>
        
        <footer>
            <p>&copy; 2023 Dealer & Online Shop Locator. All rights reserved.</p>
        </footer>
    </div>

    <script>
        // Sample data for dealers
        const dealers = [
            {
                id: 1,
                name: "City Electronics",
                type: "premium",
                address: "123 Main Street, Downtown",
                phone: "(555) 123-4567",
                hours: "Mon-Fri: 9AM-8PM, Sat: 10AM-6PM",
                lat: 40.7128,
                lng: -74.0060,
                distance: "0.5 miles"
            },
            {
                id: 2,
                name: "Tech Solutions",
                type: "authorized",
                address: "456 Oak Avenue, West District",
                phone: "(555) 987-6543",
                hours: "Mon-Sat: 10AM-7PM, Sun: 11AM-5PM",
                lat: 40.7214,
                lng: -74.0123,
                distance: "1.2 miles"
            },
            {
                id: 3,
                name: "Gadget Hub",
                type: "premium",
                address: "789 Tech Boulevard, East Side",
                phone: "(555) 456-7890",
                hours: "Mon-Fri: 8AM-9PM, Sat-Sun: 9AM-6PM",
                lat: 40.7056,
                lng: -74.0081,
                distance: "0.8 miles"
            },
            {
                id: 4,
                name: "Digital World",
                type: "authorized",
                address: "321 Innovation Road, North Quarter",
                phone: "(555) 234-5678",
                hours: "Mon-Fri: 10AM-8PM, Sat: 10AM-6PM",
                lat: 40.7182,
                lng: -74.0025,
                distance: "1.0 miles"
            },
            {
                id: 5,
                name: "Service Central",
                type: "service",
                address: "555 Repair Lane, Central District",
                phone: "(555) 876-5432",
                hours: "Mon-Fri: 9AM-6PM, Sat: 10AM-4PM",
                lat: 40.7098,
                lng: -74.0152,
                distance: "1.5 miles"
            },
            {
                id: 6,
                name: "Pro Tech Service",
                type: "service",
                address: "222 Fixit Street, South End",
                phone: "(555) 345-6789",
                hours: "Mon-Sat: 8AM-7PM",
                lat: 40.7253,
                lng: -74.0217,
                distance: "2.0 miles"
            },
            {
                id: 7,
                name: "Elite Electronics",
                type: "premium",
                address: "888 Premium Plaza, Uptown",
                phone: "(555) 567-8901",
                hours: "Mon-Sat: 9AM-9PM, Sun: 10AM-6PM",
                lat: 40.7321,
                lng: -74.0098,
                distance: "1.8 miles"
            },
            {
                id: 8,
                name: "Value Tech",
                type: "authorized",
                address: "777 Budget Avenue, East End",
                phone: "(555) 678-9012",
                hours: "Mon-Fri: 10AM-8PM, Sat-Sun: 10AM-6PM",
                lat: 40.7015,
                lng: -74.0234,
                distance: "2.2 miles"
            }
        ];

        // Initialize map
        const map = L.map('map').setView([40.7128, -74.0060], 13);
        
        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Create markers
        const markers = [];
        dealers.forEach(dealer => {
            const marker = L.marker([dealer.lat, dealer.lng]).addTo(map);
            marker.bindPopup(`<b>${dealer.name}</b><br>${dealer.address}`);
            markers.push({
                id: dealer.id,
                marker: marker
            });
        });

        // Render dealer results
        function renderResults(filter = "all") {
            const resultsList = document.getElementById('results-list');
            resultsList.innerHTML = '';
            
            const filteredDealers = filter === "all" ? 
                dealers : 
                dealers.filter(dealer => dealer.type === filter);
            
            filteredDealers.forEach(dealer => {
                const card = document.createElement('div');
                card.className = 'result-card';
                card.dataset.id = dealer.id;
                
                card.innerHTML = `
                    <div class="result-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="result-details">
                        <h3>${dealer.name}</h3>
                        <span class="result-type">${getTypeLabel(dealer.type)}</span>
                        <p class="result-address"><i class="fas fa-map-marker-alt"></i> ${dealer.address} • ${dealer.distance}</p>
                        <p class="result-phone"><i class="fas fa-phone"></i> ${dealer.phone}</p>
                        <p class="result-hours"><i class="fas fa-clock"></i> ${dealer.hours}</p>
                    </div>
                `;
                
                card.addEventListener('click', () => {
                    // Remove active class from all cards
                    document.querySelectorAll('.result-card').forEach(c => {
                        c.classList.remove('active');
                    });
                    
                    // Add active class to clicked card
                    card.classList.add('active');
                    
                    // Find the marker and open its popup
                    const markerObj = markers.find(m => m.id === dealer.id);
                    if (markerObj) {
                        map.setView([dealer.lat, dealer.lng], 15);
                        markerObj.marker.openPopup();
                    }
                });
                
                resultsList.appendChild(card);
            });
            
            // Update results count
            document.querySelector('.results-count').textContent = `${filteredDealers.length} results`;
        }

        // Get type label
        function getTypeLabel(type) {
            const labels = {
                "premium": "Premium Dealer",
                "authorized": "Authorized Dealer",
                "service": "Service Center"
            };
            return labels[type] || type;
        }

        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                button.classList.add('active');
                
                // Filter results
                renderResults(button.dataset.filter);
            });
        });

        // Search functionality
        document.getElementById('search-btn').addEventListener('click', () => {
            const locationInput = document.getElementById('location-input').value;
            if (locationInput.trim() !== '') {
                alert(`Searching for dealers near: ${locationInput}`);
                // In a real app, this would trigger geocoding and map update
            }
        });

        // Initialize with all results
        renderResults();
    </script>
</body>
</html>