<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')
</head>

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
            <!-- User List Start -->
            <div class="container">
                <h1 class="my-4">User List</h1>
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Addresses</th>
                            <th>Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->addresses->isEmpty())
                                <p>No address available.</p>
                                @else
                                @foreach($user->addresses as $address)
                                <div>
                                    <strong>{{ $address->first_name }} {{ $address->last_name }}</strong><br>
                                    {{ $address->address }} {{ $address->apartment }}<br>
                                    {{ $address->city }}, {{ $address->country }} - {{ $address->pin_code }}<br>
                                    Phone: {{ $address->phone }}
                                </div>
                                <hr>
                                @endforeach
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
            <!-- User List End -->
        </div>
        <!-- Content End -->
        @include('admin.include.footer')
    </div>
</body>

</html>