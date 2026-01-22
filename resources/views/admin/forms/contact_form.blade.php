<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')

<body>
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
          <!-- Contact Enquiry Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0 text-white">Contact Enquiry Form</h6>
            {{-- You can add an Export button or search filter here --}}
            <div>
                <input type="text" id="filterInput" class="form-control d-inline-block me-2" placeholder="Search..." style="width: 200px;">
                <button id="exportExcel" class="btn btn-success btn-sm">Export to Excel</button>
            </div>

        </div>

        <div class="table-responsive">
            @if($applyForms->count())
                <table class="table text-start align-middle table-bordered table-hover mb-0" id="contactTable">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Message</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applyForms as $index => $form)
                        <tr>
                            <td>{{ ($applyForms->currentPage() - 1) * $applyForms->perPage() + $index + 1 }}</td>
                            <td>{{ $form->name }}</td>
                            <td>{{ $form->email }}</td>
                            <td>{{ $form->phone }}</td>
                            <td>{{ $form->subject }}</td>
                            <td>{{ Str::limit($form->message, 50) }}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.contact.detail', $form->id) }}">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-3 d-flex justify-content-center">
                    {{ $applyForms->links('pagination::bootstrap-5') }}
                </div>
            @else
                <p class="text-white">No contact enquiries found.</p>
            @endif
        </div>
    </div>
</div>




<!-- Contact Enquiry End -->
<!-- SheetJS CDN for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    // Filter rows in table
    document.getElementById("filterInput").addEventListener("keyup", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#contactTable tbody tr");
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // Export table to Excel
    document.getElementById("exportExcel").addEventListener("click", function () {
        const table = document.getElementById("contactTable");
        const wb = XLSX.utils.table_to_book(table, { sheet: "Contact Enquiries" });
        XLSX.writeFile(wb, "Contact-Enquiries.xlsx");
    });
</script>

            @include('admin.include.footer')
</body>

</html>