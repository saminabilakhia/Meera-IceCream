<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Get data
try {
    $stmt = $pdo->query("SELECT * FROM franchise_requests ORDER BY created_at DESC");
    $requests = $stmt->fetchAll();
    
    $stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
    $messages = $stmt->fetchAll();
    
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
    $products = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Error fetching data: " . $e->getMessage();
}

// Handle deletions
if (isset($_GET['delete']) && isset($_GET['type'])) {
    $id = $_GET['delete'];
    $type = $_GET['type'];
    
    try {
        if ($type === 'franchise') {
            $stmt = $pdo->prepare("DELETE FROM franchise_requests WHERE id = ?");
        } elseif ($type === 'contact') {
            $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
        } elseif ($type === 'product') {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        }
        
        if (isset($stmt)) {
            $stmt->execute([$id]);
            header('Location: dashboard.php');
            exit;
        }
    } catch(PDOException $e) {
        $error = "Error deleting record.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Meera Icecreams</title>
    <link rel="icon" type="image/jpeg" href="../assets/img/icons/WhatsApp Image 2025-10-13 at 3.10.32 AM.jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Nunito+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="admin-container" style="margin-top: 20px;">
        <div class="admin-header">
            <div>
                <h1><img src="../assets/img/icons/WhatsApp Image 2025-10-13 at 3.10.32 AM.jpeg" alt="Meera Icecreams" style="height: 45px; margin-right: 12px; border-radius: 5px;"> Meera Icecreams Admin</h1>
                <p>Welcome back, <?php echo $_SESSION['admin_username']; ?>!</p>
            </div>
            <div>
                <a href="../index.html" class="btn" style="margin-right: 10px;"><i class="fas fa-globe"></i> View Website</a>
                <a href="logout.php" class="btn" style="background: #ff4757;"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
        
        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($requests); ?></div>
                <div class="stat-label"><i class="fas fa-handshake"></i> Franchise Applications</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, var(--mint), #4FC3F7);">
                <div class="stat-number"><?php echo count($messages); ?></div>
                <div class="stat-label"><i class="fas fa-envelope"></i> Contact Messages</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, var(--chocolate), #8D6E63);">
                <div class="stat-number"><?php echo count($products); ?></div>
                <div class="stat-label"><i class="fas fa-ice-cream"></i> Products</div>
            </div>
        </div>
        
        <div class="admin-nav">
            <button onclick="showSection('franchise')" class="nav-btn active" id="franchise-btn">
                <i class="fas fa-handshake"></i> Franchise Applications
            </button>
            <button onclick="showSection('contact')" class="nav-btn" id="contact-btn">
                <i class="fas fa-envelope"></i> Contact Messages
            </button>
            <button onclick="showSection('products')" class="nav-btn" id="products-btn">
                <i class="fas fa-ice-cream"></i> Manage Products
            </button>
        </div>
        
        <?php if (isset($error)): ?>
            <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <!-- Franchise Applications Section -->
        <div id="franchise-section" class="section-card">
            <div class="section-header">
                <h3><i class="fas fa-handshake"></i> Franchise Applications</h3>
                <span style="background: var(--pink); color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.9rem;"><?php echo count($requests); ?> Total</span>
            </div>
            <div class="section-content">
            
            <?php if (empty($requests)): ?>
                <div class="empty-state">
                    <i class="fas fa-handshake"></i>
                    <h3>No Applications Yet</h3>
                    <p>Franchise applications will appear here when submitted.</p>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Investment</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $request): ?>
                            <tr>
                                <td><?php echo $request['id']; ?></td>
                                <td><?php echo htmlspecialchars($request['name']); ?></td>
                                <td><?php echo htmlspecialchars($request['email']); ?></td>
                                <td><?php echo htmlspecialchars($request['phone']); ?></td>
                                <td><?php echo htmlspecialchars($request['city']); ?></td>
                                <td><?php echo htmlspecialchars($request['investment']); ?></td>
                                <td><?php echo date('M j, Y', strtotime($request['created_at'])); ?></td>
                                <td>
                                    <button onclick="viewDetails(<?php echo $request['id']; ?>, 'franchise')" class="action-btn btn-view">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button onclick="deleteRecord(<?php echo $request['id']; ?>, 'franchise')" class="action-btn btn-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            </div>
        </div>
        
        <!-- Contact Messages Section -->
        <div id="contact-section" class="section-card" style="display: none;">
            <div class="section-header">
                <h3><i class="fas fa-envelope"></i> Contact Messages</h3>
                <span style="background: var(--mint); color: var(--chocolate); padding: 5px 15px; border-radius: 20px; font-size: 0.9rem;"><?php echo count($messages); ?> Total</span>
            </div>
            <div class="section-content">
            
            <?php if (empty($messages)): ?>
                <div class="empty-state">
                    <i class="fas fa-envelope"></i>
                    <h3>No Messages Yet</h3>
                    <p>Customer messages will appear here when submitted.</p>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message): ?>
                            <tr>
                                <td><?php echo $message['id']; ?></td>
                                <td><?php echo htmlspecialchars($message['name']); ?></td>
                                <td><?php echo htmlspecialchars($message['email']); ?></td>
                                <td><?php echo htmlspecialchars($message['subject'] ?: 'No subject'); ?></td>
                                <td><?php echo date('M j, Y', strtotime($message['created_at'])); ?></td>
                                <td>
                                    <button onclick="viewDetails(<?php echo $message['id']; ?>, 'contact')" class="action-btn btn-view">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button onclick="deleteRecord(<?php echo $message['id']; ?>, 'contact')" class="action-btn btn-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            </div>
        </div>
        
        <!-- Products Section -->
        <div id="products-section" class="section-card" style="display: none;">
            <div class="section-header">
                <h3><i class="fas fa-ice-cream"></i> Product Management</h3>
                <button onclick="showAddProduct()" class="btn">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>
            <div class="section-content">
            
            <?php if (empty($products)): ?>
                <div class="empty-state">
                    <i class="fas fa-ice-cream"></i>
                    <h3>No Products Yet</h3>
                    <p>Add your first product to get started.</p>
                    <button onclick="showAddProduct()" class="btn" style="margin-top: 15px;">
                        <i class="fas fa-plus"></i> Add Product
                    </button>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><span class="badge" style="background: var(--mint); color: var(--chocolate);"><?php echo ucfirst($product['category']); ?></span></td>
                                <td><strong>₹<?php echo number_format($product['price'], 2); ?></strong></td>
                                <td>
                                    <span class="badge" style="background: <?php echo $product['is_active'] ? '#4CAF50' : '#ff4757'; ?>; color: white;">
                                        <?php echo $product['is_active'] ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <button onclick="viewDetails(<?php echo $product['id']; ?>, 'product')" class="action-btn btn-view">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button onclick="deleteRecord(<?php echo $product['id']; ?>, 'product')" class="action-btn btn-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            </div>
        </div>
        
    </div>

    <!-- Modal for viewing details -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #eee;">
                <h3 id="modalTitle">Details</h3>
                <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #666;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="modalContent"></div>
            <div style="text-align: right; margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
                <button onclick="closeModal()" class="btn">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>

    <script>
        const requests = <?php echo json_encode($requests); ?>;
        const messages = <?php echo json_encode($messages); ?>;
        const products = <?php echo json_encode($products); ?>;
        
        function showSection(section) {
            // Hide all sections
            document.getElementById('franchise-section').style.display = 'none';
            document.getElementById('contact-section').style.display = 'none';
            document.getElementById('products-section').style.display = 'none';
            
            // Remove active class from all buttons
            document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active'));
            
            // Show selected section and activate button
            document.getElementById(section + '-section').style.display = 'block';
            document.getElementById(section + '-btn').classList.add('active');
        }
        
        function viewDetails(id, type) {
            let content = '';
            let title = '';
            
            if (type === 'franchise') {
                title = '<i class="fas fa-handshake"></i> Franchise Application Details';
                const request = requests.find(r => r.id == id);
                if (request) {
                    content = `
                        <div style="display: grid; gap: 15px;">
                            <div><strong><i class="fas fa-user"></i> Name:</strong> ${request.name}</div>
                            <div><strong><i class="fas fa-envelope"></i> Email:</strong> <a href="mailto:${request.email}">${request.email}</a></div>
                            <div><strong><i class="fas fa-phone"></i> Phone:</strong> <a href="tel:${request.phone}">${request.phone}</a></div>
                            <div><strong><i class="fas fa-map-marker-alt"></i> City:</strong> ${request.city}</div>
                            <div><strong><i class="fas fa-dollar-sign"></i> Investment:</strong> ${request.investment}</div>
                            <div><strong><i class="fas fa-calendar"></i> Date:</strong> ${new Date(request.created_at).toLocaleDateString()}</div>
                            <div><strong><i class="fas fa-comment"></i> Message:</strong></div>
                            <div style="background: var(--cream); padding: 15px; border-radius: 10px; border-left: 4px solid var(--pink);">
                                ${request.message || 'No message provided'}
                            </div>
                        </div>
                    `;
                }
            } else if (type === 'contact') {
                title = '<i class="fas fa-envelope"></i> Contact Message Details';
                const message = messages.find(m => m.id == id);
                if (message) {
                    content = `
                        <div style="display: grid; gap: 15px;">
                            <div><strong><i class="fas fa-user"></i> Name:</strong> ${message.name}</div>
                            <div><strong><i class="fas fa-envelope"></i> Email:</strong> <a href="mailto:${message.email}">${message.email}</a></div>
                            <div><strong><i class="fas fa-phone"></i> Phone:</strong> ${message.phone ? `<a href="tel:${message.phone}">${message.phone}</a>` : 'Not provided'}</div>
                            <div><strong><i class="fas fa-tag"></i> Subject:</strong> ${message.subject || 'No subject'}</div>
                            <div><strong><i class="fas fa-calendar"></i> Date:</strong> ${new Date(message.created_at).toLocaleDateString()}</div>
                            <div><strong><i class="fas fa-comment"></i> Message:</strong></div>
                            <div style="background: var(--cream); padding: 15px; border-radius: 10px; border-left: 4px solid var(--mint);">
                                ${message.message}
                            </div>
                        </div>
                    `;
                }
            } else if (type === 'product') {
                title = '<i class="fas fa-ice-cream"></i> Product Details';
                const product = products.find(p => p.id == id);
                if (product) {
                    content = `
                        <div style="display: grid; gap: 15px;">
                            ${product.image_url ? `<div style="text-align: center;"><img src="${product.image_url}" style="max-width: 300px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);"></div>` : ''}
                            <div><strong><i class="fas fa-ice-cream"></i> Name:</strong> ${product.name}</div>
                            <div><strong><i class="fas fa-tag"></i> Category:</strong> <span style="background: var(--mint); color: var(--chocolate); padding: 5px 10px; border-radius: 15px; font-size: 0.9rem;">${product.category}</span></div>
                            <div><strong><i class="fas fa-rupee-sign"></i> Price:</strong> <span style="font-size: 1.2rem; color: var(--chocolate); font-weight: bold;">₹${parseFloat(product.price).toFixed(2)}</span></div>
                            <div><strong><i class="fas fa-toggle-on"></i> Status:</strong> <span style="background: ${product.is_active ? '#4CAF50' : '#ff4757'}; color: white; padding: 5px 10px; border-radius: 15px; font-size: 0.9rem;">${product.is_active ? 'Active' : 'Inactive'}</span></div>
                            <div><strong><i class="fas fa-align-left"></i> Description:</strong></div>
                            <div style="background: var(--cream); padding: 15px; border-radius: 10px; border-left: 4px solid var(--chocolate);">
                                ${product.description || 'No description available'}
                            </div>
                        </div>
                    `;
                }
            }
            
            document.getElementById('modalTitle').innerHTML = title;
            document.getElementById('modalContent').innerHTML = content;
            document.getElementById('detailModal').style.display = 'block';
        }
        
        function deleteRecord(id, type) {
            const messages = {
                'franchise': 'Are you sure you want to delete this franchise application?',
                'contact': 'Are you sure you want to delete this contact message?',
                'product': 'Are you sure you want to delete this product?'
            };
            
            if (confirm(messages[type])) {
                window.location.href = `?delete=${id}&type=${type}`;
            }
        }
        
        function showAddProduct() {
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus"></i> Add New Product';
            document.getElementById('modalContent').innerHTML = `
                <form method="POST" action="add_product.php" style="display: grid; gap: 20px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: var(--chocolate);"><i class="fas fa-ice-cream"></i> Product Name *</label>
                        <input type="text" name="name" placeholder="Enter product name" required style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 16px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: var(--chocolate);"><i class="fas fa-tag"></i> Category *</label>
                        <select name="category" required style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 16px;">
                            <option value="">Select Category</option>
                            <option value="cone">Cone</option>
                            <option value="cup">Cup</option>
                            <option value="family">Family Pack</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: var(--chocolate);"><i class="fas fa-rupee-sign"></i> Price *</label>
                        <input type="number" name="price" placeholder="0.00" step="0.01" required style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 16px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: var(--chocolate);"><i class="fas fa-align-left"></i> Description</label>
                        <textarea name="description" placeholder="Product description..." style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; height: 100px; font-size: 16px; resize: vertical;"></textarea>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: var(--chocolate);"><i class="fas fa-image"></i> Image URL</label>
                        <input type="url" name="image_url" placeholder="https://example.com/image.jpg" style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 16px;">
                    </div>
                    <button type="submit" class="btn" style="width: 100%; padding: 15px; font-size: 16px;">
                        <i class="fas fa-plus"></i> Add Product
                    </button>
                </form>
            `;
            document.getElementById('detailModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('detailModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>