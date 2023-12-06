<div>
    {{-- {{ $getState() }} --}}
    {{-- <div  x-data="{ jeeva: '' }">
        <button x-on:click="
         jeeva='sdf'
        alert(jeeva);
        ">copy</button>
    </div> --}}
    <div x-data="{ jeeva: '' }" x-init="jeeva = '{{ $getState() }}'">
        <button x-on:click="navigator.clipboard.writeText(jeeva).then(() => { 
            {{-- alert('Copied: ' + jeeva);  --}}
        })">
            Copy
        </button>
    </div>
</div>
