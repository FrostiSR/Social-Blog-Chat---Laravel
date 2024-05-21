<x-profile :sharedData="$sharedData" doctitle="{{ $sharedData['username'] }}">
    @include('profile-only');
</x-profile>
