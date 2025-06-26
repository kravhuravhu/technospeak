<div class="form-card">
    <div class="form-row">
        <div class="form-group">
            <label for="title" class="form-label">Course Title</label>
            <input type="text" id="title" name="title" class="form-control" 
                   value="{{ old('title', $course->title ?? '') }}" required>
            @error('title')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="category_id" class="form-label">Category</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ (old('category_id', $course->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="form-group">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $course->description ?? '') }}</textarea>
        @error('description')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="price" class="form-label">Price ($)</label>
            <input type="number" id="price" name="price" class="form-control" 
                   value="{{ old('price', $course->price ?? '') }}" step="0.01" min="0">
            @error('price')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="duration" class="form-label">Duration (hours)</label>
            <input type="number" id="duration" name="duration" class="form-control" 
                   value="{{ old('duration', $course->duration ?? '') }}">
            @error('duration')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="is_active" class="form-label">Status</label>
            <select id="is_active" name="is_active" class="form-control">
                <option value="1" {{ (old('is_active', $course->is_active ?? true) ? 'selected' : '') }}>Active</option>
                <option value="0" {{ !(old('is_active', $course->is_active ?? true)) ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <label for="image" class="form-label">Course Image</label>
        <input type="file" id="image" name="image" class="form-control">
        @error('image')
            <div class="error-message">{{ $message }}</div>
        @enderror
        @if(isset($course) && $course->image)
            <div style="margin-top: 10px;">
                <img src="{{ asset('storage/' . $course->image) }}" alt="Course Image" style="max-width: 200px; border-radius: 8px;">
            </div>
        @endif
    </div>
    
    <div class="form-group" style="margin-top: 1.5rem;">
        <button type="submit" class="btn btn-primary">
            {{ isset($course) ? 'Update Course' : 'Create Course' }}
        </button>
        <a href="{{ route('content-manager.courses.index') }}" class="btn btn-outline">
            Cancel
        </a>
    </div>
</div>
