<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submissions Dashboard - Anthony Darko Ministries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        :root {
            --primary: #0d9488;
            --secondary: #dd6b20;
            --light: #f8f9fa;
            --dark: #343a40;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
        }
        
        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background: var(--primary);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
        }
        
        .logo-text h1 {
            font-size: 1.8rem;
            line-height: 1.2;
        }
        
        .logo-text p {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .controls {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-secondary {
            background: var(--secondary);
            color: white;
        }
        
        .btn-success {
            background: var(--success);
            color: white;
        }
        
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 20px;
            margin-top: 20px;
        }
        
        .sidebar {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .sidebar h3 {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .filters {
            list-style: none;
        }
        
        .filters li {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }
        
        .filters li:hover, .filters li.active {
            background: #f0f9ff;
            color: var(--primary);
        }
        
        .filters li i {
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border-left: 4px solid var(--primary);
        }
        
        .stat-card h4 {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .stat-card .number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #495057;
            position: sticky;
            top: 0;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .badge-success {
            background: #e6f4ea;
            color: var(--success);
        }
        
        .badge-warning {
            background: #fff8e1;
            color: var(--warning);
        }
        
        .badge-info {
            background: #e6f7ff;
            color: var(--info);
        }
        
        .actions {
            display: flex;
            gap: 10px;
        }
        
        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        
        .view-btn {
            background: #e6f7ff;
            color: var(--info);
        }
        
        .delete-btn {
            background: #ffe6e6;
            color: var(--danger);
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 10px;
        }
        
        .pagination button {
            padding: 8px 15px;
            border: 1px solid #dee2e6;
            background: white;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .pagination button.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            border-radius: 10px;
            width: 600px;
            max-width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .close {
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 15px;
        }
        
        .detail-label {
            flex: 1;
            font-weight: 600;
            color: #6c757d;
        }
        
        .detail-value {
            flex: 2;
        }
        
        @media (max-width: 992px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
            
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 576px) {
            .stats {
                grid-template-columns: 1fr;
            }
            
            header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .controls {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="C:\xampp\htdocs\anthony-darko-ministries\Logo.jpeg" alt="Logo">
                <div class="logo-text">
                    <h1>Form Submissions Dashboard</h1>
                    <p>Anthony Darko Ministries</p>
                </div>
            </div>
            <div class="controls">
                <button class="btn btn-primary"><i class="fas fa-sync-alt"></i> Refresh</button>
                <button class="btn btn-success"><i class="fas fa-download"></i> Export</button>
            </div>
        </header>
        
        <div class="dashboard">
            <div class="sidebar">
                <h3>Form Types</h3>
                <ul class="filters">
                    <li class="active"><i class="fas fa-all"></i> All Submissions</li>
                    <li><i class="fas fa-pray"></i> Prayer Requests</li>
                    <li><i class="fas fa-hand-holding-heart"></i> Giving</li>
                    <li><i class="fas fa-users"></i> Membership</li>
                    <li><i class="fas fa-handshake"></i> Partnership</li>
                    <li><i class="fas fa-graduation-cap"></i> Discipleship</li>
                </ul>
                
                <h3>Date Filter</h3>
                <div style="margin-top: 15px;">
                    <input type="date" style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ced4da;">
                </div>
                
                <button class="btn btn-secondary" style="margin-top: 15px; width: 100%;">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
            </div>
            
            <div class="main-content">
                <div class="stats">
                    <div class="stat-card">
                        <h4>Total Submissions</h4>
                        <div class="number">142</div>
                    </div>
                    <div class="stat-card">
                        <h4>Prayer Requests</h4>
                        <div class="number">38</div>
                    </div>
                    <div class="stat-card">
                        <h4>Giving Records</h4>
                        <div class="number">24</div>
                    </div>
                    <div class="stat-card">
                        <h4>New Members</h4>
                        <div class="number">19</div>
                    </div>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Form Type</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#1025</td>
                                <td>John Smith</td>
                                <td>john.smith@example.com</td>
                                <td>Prayer Request</td>
                                <td>Jun 12, 2023</td>
                                <td><span class="badge badge-success">Reviewed</span></td>
                                <td class="actions">
                                    <button class="action-btn view-btn" onclick="openModal()"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#1024</td>
                                <td>Sarah Johnson</td>
                                <td>sarahj@example.com</td>
                                <td>Partnership</td>
                                <td>Jun 11, 2023</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td class="actions">
                                    <button class="action-btn view-btn" onclick="openModal()"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#1023</td>
                                <td>Michael Brown</td>
                                <td>m.brown@example.com</td>
                                <td>Giving</td>
                                <td>Jun 10, 2023</td>
                                <td><span class="badge badge-success">Processed</span></td>
                                <td class="actions">
                                    <button class="action-btn view-btn" onclick="openModal()"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#1022</td>
                                <td>Emily Davis</td>
                                <td>emilyd@example.com</td>
                                <td>Membership</td>
                                <td>Jun 9, 2023</td>
                                <td><span class="badge badge-info">New</span></td>
                                <td class="actions">
                                    <button class="action-btn view-btn" onclick="openModal()"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#1021</td>
                                <td>Robert Wilson</td>
                                <td>rwilson@example.com</td>
                                <td>Discipleship</td>
                                <td>Jun 8, 2023</td>
                                <td><span class="badge badge-success">Contacted</span></td>
                                <td class="actions">
                                    <button class="action-btn view-btn" onclick="openModal()"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination">
                    <button><i class="fas fa-chevron-left"></i></button>
                    <button class="active">1</button>
                    <button>2</button>
                    <button>3</button>
                    <button><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal for viewing submission details -->
    <div class="modal" id="detailsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Submission Details #1025</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="detail-row">
                    <div class="detail-label">Name:</div>
                    <div class="detail-value">John Smith</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value">john.smith@example.com</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Phone:</div>
                    <div class="detail-value">+1 555-123-4567</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Form Type:</div>
                    <div class="detail-value">Prayer Request</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Submission Date:</div>
                    <div class="detail-value">June 12, 2023 at 14:32</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Status:</div>
                    <div class="detail-value"><span class="badge badge-success">Reviewed</span></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Prayer Request:</div>
                    <div class="detail-value">Please pray for healing for my mother who is undergoing surgery next week. Also for strength and comfort for our family during this difficult time.</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">IP Address:</div>
                    <div class="detail-value">192.168.1.105</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality
        function openModal() {
            document.getElementById('detailsModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('detailsModal').style.display = 'none';
        }
        
        // Close modal if clicked outside
        window.onclick = function(event) {
            const modal = document.getElementById('detailsModal');
            if (event.target === modal) {
                closeModal();
            }
        };
        
        // Filter functionality
        const filterItems = document.querySelectorAll('.filters li');
        filterItems.forEach(item => {
            item.addEventListener('click', function() {
                filterItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Simulate loading data
        document.querySelector('.btn-primary').addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i> Refreshing...';
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-sync-alt"></i> Refresh';
                alert('Data refreshed successfully!');
            }, 1500);
        });
    </script>
</body>
</html>