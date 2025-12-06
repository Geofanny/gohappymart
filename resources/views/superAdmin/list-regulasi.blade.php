<div class="accordion" id="accordion{{ ucfirst($jenis) }}">
    @foreach ($data as $index => $item)
        <div class="accordion-item border mb-2 rounded">
            <h2 class="accordion-header" id="heading{{ ucfirst($jenis) }}{{ $index }}">
                <div class="d-flex align-items-center justify-content-between px-3 py-2">
                    <button class="accordion-button collapsed flex-grow-1" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse{{ ucfirst($jenis) }}{{ $index }}">
                        {{ $loop->iteration }}. {{ $item->judul }}
                    </button>
                </div>
            </h2>
            <div id="collapse{{ ucfirst($jenis) }}{{ $index }}" class="accordion-collapse collapse">
                <div class="accordion-body">{!! $item->isi !!}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-2">
    {{ $data->links() }}
</div>
