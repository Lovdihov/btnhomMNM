<x-admin-layout>
    <x-slot name="title">Sửa bài hát: {{ $song->title }}</x-slot>

    <style>
        .edit-container {
            max-width: 800px;
            margin: 30px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #eef0f7;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.2s;
            
        }

        .form-control:focus {
            border-color: #4e73df;
            outline: none;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
    
        }

        .btn-submit {
            background-color: #4e73df;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background-color: #2e59d9;
        }

        .grid-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .header-title {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 20px;
        }

        .alert-box {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
        }

        .alert-error {
            background: #fff2f2;
            color: #b42318;
            border: 1px solid #ffd0d0;
        }

        .field-error {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: #dc3545;
            font-weight: 600;
        }
    </style>

    <div class="edit-container">
        <h1 class="header-title">Chỉnh sửa bài hát</h1>

        @if ($errors->any())
            <div class="alert-box alert-error">
                Vui lòng kiểm tra lại các thông tin bên dưới.
            </div>
        @endif

        <form action="{{ route('admin.songs.update', $song->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Dòng 1: Tiêu đề --}}
            <div class="form-group">
                <label>Tiêu đề bài hát</label>
                <input type="text" name="title" value="{{ $song->title }}" required class="form-control" placeholder="Nhập tên bài hát...">
                @error('title') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            {{-- Dòng 2: Chia 2 cột cho Album và Ảnh bìa --}}
            <div class="grid-layout">
                <div class="form-group">
                    <label>Album</label>
                    <select name="album_id" class="form-control">
                        <option value="">-- Không có album --</option>
                        @foreach($albums as $album)
                            <option value="{{ $album->id }}" {{ $song->album_id == $album->id ? 'selected' : '' }}>
                                {{ $album->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('album_id') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $song->status == 1 ? 'selected' : '' }}>Hiện bài hát</option>
                        <option value="0" {{ $song->status == 0 ? 'selected' : '' }}>Ẩn bài hát</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Nghệ sĩ</label>
                <select name="artists[]" class="form-control" multiple size="5">
                    @foreach($artists as $artist)
                        <option value="{{ $artist->id }}" {{ in_array($artist->id, old('artists', $song->artists->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $artist->name }}
                        </option>
                    @endforeach
                </select>
                @error('artists') <span class="field-error">{{ $message }}</span> @enderror
                @error('artists.*') <span class="field-error">{{ $message }}</span> @enderror
                <div style="font-size:11px;color:#666;margin-top:4px;">Giữ Ctrl (hoặc Cmd trên Mac) để chọn nhiều nghệ sĩ.</div>
            </div>

            <div class="form-group">
                <label>Tâm trạng (Mood)</label>
                <select name="mood" class="form-control">
                    <option value="">-- Chưa chọn --</option>
                    <option value="chill" {{ $song->mood == 'chill' ? 'selected' : '' }}>Chill</option>
                    <option value="lam-viec" {{ $song->mood == 'lam-viec' ? 'selected' : '' }}>Làm việc</option>
                    <option value="buon" {{ $song->mood == 'buon' ? 'selected' : '' }}>Buồn</option>
                    <option value="party" {{ $song->mood == 'party' ? 'selected' : '' }}>Party</option>
                </select>
                @error('mood') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            {{-- Dòng 3: URL Audio --}}
            <div class="form-group">
                <label>Audio URL (Đường dẫn nhạc)</label>
                <input type="text" name="audio_url" value="{{ $song->audio_url }}" required class="form-control" placeholder="https://...">
                @error('audio_url') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            {{-- Dòng 4: URL Ảnh bìa --}}
            <div class="form-group">
                <label>Ảnh bìa URL</label>
                <input type="text" name="cover_url" value="{{ $song->cover_url }}" class="form-control" placeholder="https://...">
                @error('cover_url') <span class="field-error">{{ $message }}</span> @enderror
                @if($song->cover_url)
                    <div style="margin-top: 10px;">
                        <img src="{{ $song->cover_url }}" width="80" height="80" style="border-radius: 8px; object-fit: cover; border: 1px solid #ddd;">
                        <p style="font-size: 11px; color: #888;">Xem trước ảnh hiện tại</p>
                    </div>
                @endif
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <a href="{{ route('admin.songs') }}" style="flex: 1; text-align: center; padding: 12px; background: #f8f9fc; border: 1px solid #d1d3e2; color: #4e73df; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Quay lại
                </a>
                <button type="submit" class="btn-submit" style="flex: 2;">
                    LƯU THAY ĐỔI
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>