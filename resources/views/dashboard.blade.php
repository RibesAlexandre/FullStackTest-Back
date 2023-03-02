<x-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        @if( session()->has('error') )
            <div class="flex items-center gap-x-6 bg-red-600 py-2.5 px-6 sm:px-3.5 sm:before:flex-1 my-3 rounded text-center">
                <p class="text-sm leading-6 text-white text-center">
                   {{ session('error') }}
                </p>
            </div>
        @endif
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Liste des devises</h1>
                <p class="mt-2 text-sm text-gray-700">Administrer vos devises</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <form action="{{ route('dashboard.store') }}" method="POST" class="flex">
                    @csrf
                    <div class="mr-2">
                        <label for="code" class="sr-only">Code</label>
                        <div>
                            <input type="text" name="code" id="code" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Code de la devise">
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="block rounded-md bg-indigo-600 py-1.5 px-3 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ajouter devise</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Nom</th>
                            <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Code</th>
                            <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900 text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @foreach( $currencies as $currency )
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $currency->name }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{ $currency->code }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('dashboard.delete', $currency->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="block rounded-md bg-red-600 py-1.5 px-3 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>