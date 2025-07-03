@extends('layouts.app')

@section('content')
    <h2>Dodaj nowe zwierzę</h2>

    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pets.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Nazwa zwierzęcia:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="">Wybierz status</option>
                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Dostępne</option>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Oczekujące</option>
                <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sprzedane</option>
            </select>
        </div>

        <div class="form-group">
            <label for="category">Kategoria:</label>
            <input type="text" id="category" name="category" value="{{ old('category', 'default') }}">
        </div>

        <div class="form-group">
            <label for="tags">Tagi:</label>
            <input type="text" id="tags" name="tags" value="{{ old('tags', 'default') }}">
        </div>

        <div class="form-group">
            <label for="photo_url">URL zdjęcia:</label>
            <input type="url" id="photo_url" name="photo_url" value="{{ old('photo_url') }}">
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" class="btn btn-success">Dodaj zwierzę</button>
            <a href="{{ route('pets.index') }}" class="btn btn-primary">Powrót do listy</a>
        </div>
    </form>
@endsection 