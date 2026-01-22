<!DOCTYPE html>
<html lang="en">

    @include('admin.include.head')

<body>

 <style>
   
 
  
    h1, h4 {
        font-weight: 600;
    }

    .container h1 {
        margin-top: 20px;
        margin-bottom: 10px;
    }

    /* Dropdown Styling */
    .dropdown-wrapper {
        margin-bottom: 20px;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .dropdown-wrapper label {
        margin-right: 10px;
        font-weight: 500;
    }

    .form-select {
        padding: 5px 10px;
        border-radius: 6px;
        border: 1px solid #ced4da;
    }

    /* Table Styling */
    .table {
        margin-bottom: 0;
        border-radius: 10px;
        overflow: hidden;
    }

    .table-bordered th, .table-bordered td {
        vertical-align: middle;
    }

    .table thead {
        background-color:rgb(64, 52, 52);
        color: #fff;
    }


    .table-striped tbody tr:hover {
        background-color: #e9ecef;
        transition: background-color 0.3s ease;
    }

    .btn {
        border-radius: 5px;
        padding: 5px 12px;
    }

    .btn-sm {
        font-size: 0.85rem;
    }

    /* Pagination Styling */
    .pagination {
        justify-content: center;
        margin: 20px 0;
    }

    .pagination .page-item .page-link {
        color:rgb(255, 0, 0);
        border: 1px solid #dee2e6;
        padding: 6px 12px;
        margin: 0 3px;
        border-radius: 6px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .pagination .page-item.active .page-link {
        background-color:rgb(255, 0, 0);
        color: #fff;
        border-color:rgb(255, 0, 0);
    }

    .pagination .page-item .page-link:hover {
        background-color: #e2e6ea;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .dropdown-wrapper {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 10px;
        }

        .dropdown-wrapper select {
            width: 100%;
        }

        .table th, .table td {
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .btn {
            margin: 2px 0;
        }
    }


    .action-buttons .btn-edit {
    background-color: #ffc107;
    color: #000;
    border: none;
    border-radius: 20px;
    padding: 5px 12px;
    transition: all 0.3s ease;
}
.action-buttons .btn-edit:hover {
    background-color: #e0a800;
    color: #fff;
}

.action-buttons .btn-delete {
    background-color:rgb(220, 53, 53);
    color: #fff;
    border: none;
    border-radius: 20px;
    padding: 5px 12px;
    transition: all 0.3s ease;
}
.action-buttons .btn-delete:hover {
    background-color:rgb(200, 35, 35);
    color: #fff;
}

</style>


    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        @include('admin.include.sidebar')

        <!-- Content Start -->
        <div class="content">
            @include('admin.include.navbar')
            <!-- Recent Sales Start -->
            <div class="container">
                <h1>Products</h1>
                <a href="{{ route('admin.add_product') }}" class="btn btn-primary mb-3">Add Product</a>
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Search bar -->
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
            </div>


<div class="dropdown-wrapper d-flex justify-content-between align-items-center">
        <h4 class="text-dark">Product List</h4>
        <div>
            <label for="rowsPerPage">Show:</label>
            <select id="rowsPerPage" class="form-select d-inline-block w-auto">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>
    </div>

        <table class="table table-striped table-bordered text-center" id="productTable">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Url</th>
            <th>Category ID</th>
            <th>Subcategory ID</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->url }}</td>
                <td>{{ $product->category_id }}</td>
                <td>{{ $product->subcategory_id }}</td>
                <td class="action-buttons">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    <nav>
        <ul class="pagination" id="pagination"></ul>
    </nav>
            </div>

<script>
    // Product Search
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#productTable tbody tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // Delete Confirmation
    function confirmDelete() {
        return confirm("Are you sure you want to delete this product?");
    }
</script>

            <script>
    document.addEventListener("DOMContentLoaded", () => {
        const table = document.querySelector("#productTable tbody");
        const rows = Array.from(table.rows);
        const rowsPerPageSelect = document.getElementById("rowsPerPage");
        const pagination = document.getElementById("pagination");

        function displayTable(page, rowsPerPage) {
            table.innerHTML = "";
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedItems = rows.slice(start, end);
            paginatedItems.forEach(row => table.appendChild(row));
        }

        function setupPagination(rowsPerPage) {
            pagination.innerHTML = "";
            const pageCount = Math.ceil(rows.length / rowsPerPage);
            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement("li");
                li.className = "page-item";
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener("click", () => {
                    document.querySelectorAll(".page-item").forEach(p => p.classList.remove("active"));
                    li.classList.add("active");
                    displayTable(i, rowsPerPage);
                });
                pagination.appendChild(li);
            }
            pagination.firstChild.classList.add("active");
        }

        rowsPerPageSelect.addEventListener("change", () => {
            const rowsPerPage = parseInt(rowsPerPageSelect.value);
            setupPagination(rowsPerPage);
            displayTable(1, rowsPerPage);
        });

        // Initialize
        setupPagination(parseInt(rowsPerPageSelect.value));
        displayTable(1, parseInt(rowsPerPageSelect.value));
    });
</script>
            <!-- Recent Sales End -->
            @include('admin.include.footer')
</body>

</html>