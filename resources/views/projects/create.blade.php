@extends('seatpm::layout')

@section('content')
<div class="container mt-4">
    <h2>Create New Project</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following issues:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('seatpm.projects.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label"><strong>Title <span class="text-danger">*</span></strong></label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="visibility" class="form-label"><strong>Visibility <span class="text-danger">*</span></strong></label>
            <select name="visibility" class="form-select" required>
                <option value="personal" {{ old('visibility') === 'personal' ? 'selected' : '' }}>Personal</option>
                <option value="corporation" {{ old('visibility') === 'corporation' ? 'selected' : '' }}>Corporation</option>
                <option value="alliance" {{ old('visibility') === 'alliance' ? 'selected' : '' }}>Alliance</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label"><strong>Description</strong></label>
            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="target_budget" class="form-label"><strong>Target Budget (ISK)</strong></label>
            <input type="number" name="target_budget" class="form-control" step="0.01" value="{{ old('target_budget') }}">
        </div>

        <div class="mb-3">
            <label for="target_completion_date" class="form-label"><strong>Target Completion Date</strong></label>
            <input type="date" name="target_completion_date" class="form-control" value="{{ old('target_completion_date') }}">
        </div>

        <button type="submit" class="btn btn-primary">Create Project</button>
        <a href="{{ route('seatpm.projects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
