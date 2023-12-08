<div>
    <div x-data="{ jeeva: '' }" x-init="jeeva = '{{ $getState() }}'">
        <button x-on:click="navigator.clipboard.writeText(jeeva).then(() => { 
            alert('Copied'); 
        })">
        {{-- {{ $getState() }} --}}
        <span x-text="'*****' + jeeva.substring(5)"> </span>
        </button>
    </div>
</div>
