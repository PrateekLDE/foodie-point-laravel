@extends('layouts.admin')

@section('title', 'Edit menu')

@section('content')

<div style="margin-bottom:16px;">
    <a href="{{ route('admin.menu-items.index', ['date' => $menuItem->date->toDateString()]) }}"
       style="color:var(--muted); text-decoration:none; font-size:.9rem;">
        ← Back to {{ $menuItem->date->format('M j') }}
    </a>
</div>

<div class="card">
    <div class="card-header">✏️ Edit menu</div>
    <div class="card-body">
        <form action="{{ route('admin.menu-items.update', $menuItem) }}" method="POST">
            @csrf @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="meal_period">Meal</label>
                    <select name="meal_period" id="meal_period" class="form-control">
                        @foreach($mealPeriods as $key => $label)
                            <option value="{{ $key }}" {{ $menuItem->meal_period === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input type="number" name="price" id="price" step="0.01" min="0"
                           value="{{ $menuItem->price }}" class="form-control" inputmode="decimal"
                           placeholder="Leave blank = ask server">
                </div>
            </div>

            <div class="form-group">
                <label for="name">Dish Name</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $menuItem->name) }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="form-control" style="resize:vertical">{{ old('description', $menuItem->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="sort_order">Display Order</label>
                <input type="number" name="sort_order" id="sort_order" min="0"
                       value="{{ old('sort_order', $menuItem->sort_order) }}"
                       class="form-control" style="width: 100px;"
                       title="Lower number = shown first">
                <small class="text-muted">Lower = shown first in that meal section</small>
            </div>

            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.menu-items.index', ['date' => $menuItem->date->toDateString()]) }}"
                   class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
