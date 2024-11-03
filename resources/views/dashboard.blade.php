<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    

    <!-- Change Password Modal -->
    <div id="password-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Change Password</h3>
                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="password-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5">
                    <form id="change-password-form" class="space-y-4" method="POST" action="{{ route('change.password') }}">
                        @csrf
                        <input type="hidden" name="id" id="user-id" value="" />
                        
                        @if ($errors->any())
                            <div class="mb-4 text-red-500">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
                        </div>
                        <div>
                            <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                            <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
                        </div>
                        <hr class="m-2" />
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">UPDATE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(Session::has('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">{{ Session('success') }}!</span>
              </div>
              @elseif(Session::has('error'))
              <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">{{ Session('error') }}</span>
              </div>
            @endif

              
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto p-2 text-center">

                    @if(Auth::user()->role === 'admin')
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Creation Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-lg">ADMIN</span>
                                    @else
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-lg">USER</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <a href="javascript:void(0)" 
                                    data-modal-target="password-modal" 
                                    data-modal-toggle="password-modal" 
                                    title="CHANGE PASSWORD" 
                                    class="text-xs font-medium text-center inline-flex items-center text-white rounded-lg"
                                    onclick="document.getElementById('user-id').value = '{{ $user->id }}';">
                                    <i style="font-size: 15px;" class="fas fa-cog text-gray-500"></i>
                                    </a>

                                    <a href="{{ route('edit.user', ['id' => $user->id]) }}" title="EDIT" class="px-2 text-xs font-medium text-center inline-flex items-center text-white rounded-lg">
                                        <i style="font-size: 15px;" class="fas fa-pencil text-yellow-500"></i>
                                      </a>
                                      <a href="{{ route('delete.user', ['id' => $user->id]) }}" title="DELETE" class="text-xs font-medium text-center inline-flex items-center text-white rounded-lg" 
                                        onclick="return confirm('Are you sure you want to delete this user?');">
                                         <i style="font-size: 15px;" class="fas fa-trash text-red-500"></i>
                                     </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Creation Date</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                    @else
                    <h1 class="text-2xl font-extrabold leading-none tracking-tight uppercase text-gray-700 md:text-2xl">This is my Dashboard</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.getElementById('change-password-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken, // Use the CSRF token from the meta tag
                    'Accept': 'application/json', // Optional, but good practice
                },
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Unexpected error');
                    });
                }
                return response.json(); // Only return JSON if response is ok
            })
            .then(data => {
                // Handle success
                document.getElementById('password-modal').classList.add('hidden');
                alert(data.message); // Show success message
                location.reload();
            })
            .catch(error => {
                // Handle error (could be validation error or server error)
                alert(error.message);
            });
        });
    });
</script>


