@extends('layouts/dashboard')

@section('content')
<div class="col-12 mt-2">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="mb-3"><i class="ti ti-edit me-2"></i> Edit Berita</h1>
            <div class="border-bottom border-success mb-4" style="border-width: 3px;"></div>

            <form action="/dashboard-admin/berita/update/{{ $berita->id_berita }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <!-- KIRI -->
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Berita</label>
                            <input type="text" class="form-control" id="judul" name="judul" 
                                   value="{{ old('judul', $berita->judul) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Banner</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">
                        </div>

                        <div id="previewCard" class="card border" style="width: 100%; height: 220px; overflow: hidden; border-radius: 10px;">
                            <img id="preview"
     src="{{ $berita->gambar ? asset('storage/uploads/berita/'.$berita->gambar) : 'https://dummyimage.com/300x220/cccccc/000000&text=No+Image' }}"
     alt="Preview Banner"
     style="width: 100%; height: 100%; object-fit: cover;">

                        </div>
                    </div>

                    <!-- KANAN -->
                    <div class="col-md-7">
                        <div class="mb-3">
                            <label for="myeditorinstance" class="form-label">Isi Berita</label>
                            <textarea id="myeditorinstance" name="isi" rows="15" class="form-control">{{ old('isi', $berita->isi) }}</textarea>
                        </div>
                        <div class="mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">
                                <i class="ti ti-device-floppy me-1"></i> Update Berita
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Image -->
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/boirjcaeyjxuv3ilkyyc9ud65xynmmc9sk4fv17mlov28lxl/tinymce/8/tinymce.min.js"
    referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
    tinymce.init({
        selector: 'textarea#myeditorinstance',
        menubar: false,
        branding: false,
        statusbar: false,
        plugins: 'lists code table',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist',
        height: 400,
        content_style: 'body { font-family:Arial,Helvetica,sans-serif; font-size:14px }'
    });
</script>
@endsection
