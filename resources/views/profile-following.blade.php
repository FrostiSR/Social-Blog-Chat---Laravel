<x-profile :sharedData="$sharedData" doctitle="{{ $sharedData['username'] }}'s' following">
    @include('profile-following-only')
</x-profile>
