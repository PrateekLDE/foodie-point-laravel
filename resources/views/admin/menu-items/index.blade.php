@extends('layouts.admin')

@section('title', 'Today\'s menus')

@section('content')

{{-- ── Date Navigation ── --}}
<div class="card mb-4">
    <div class="card-body" style="padding: 12px 16px;">
        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
            <label style="font-weight:600; white-space:nowrap;">📅 Viewing:</label>
            <input
                type="date"
                id="date-picker"
                value="{{ $date }}"
                style="border:1.5px solid var(--border); border-radius:8px; padding:8px 12px; font-size:1rem; flex:1;"
                onchange="window.location='{{ route('admin.menu-items.index') }}?date='+this.value"
            >
            @if(!$isToday)
                <a href="{{ route('admin.menu-items.index') }}" class="btn btn-outline btn-sm">
                    ← Today
                </a>
            @endif
        </div>
    </div>
</div>

{{-- ── Add New menu Form ── --}}

@if($date >= now()->toDateString())
<div class="card mb-4">
    <div class="card-header">
        <span>➕ Add a menu</span>
        @if($isToday)
            <span class="badge badge-available">Today</span>
        @endif
    </div>
    <div class="card-body">
        <form action="{{ route('admin.menu-items.store') }}" method="POST">
            @csrf
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="form-row">
                {{-- Meal period first — owner picks context before typing --}}
                <div class="form-group">
                    <label for="meal_period">Meal</label>
                    <select name="meal_period" id="meal_period" class="form-control @error('meal_period') is-invalid @enderror">
                        @foreach($mealPeriods as $key => $label)
                            <option value="{{ $key }}" {{ old('meal_period', 'all_day') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('meal_period')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input
                        type="number"
                        name="price"
                        id="price"
                        step="0.01"
                        min="0"
                        placeholder="14.99 or blank"
                        value="{{ old('price') }}"
                        class="form-control @error('price') is-invalid @enderror"
                        inputmode="decimal"
                    >
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label for="name">Dish Name <span style="color:var(--danger)">*</span></label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    list="dish-suggestions"
                    placeholder="e.g. Pan-Seared Salmon"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror"
                    autocomplete="off"
                    autofocus
                >
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror

                {{-- 
                    The datalist provides "autocomplete" suggestions based on past items.
                    The JavaScript below uses the data-attributes to auto-fill price/desc 
                    when a suggestion is picked. 
                --}}
                <datalist id="dish-suggestions">
                    @foreach($suggestedItems as $item)
                        <option value="{{ $item->name }}"
                                data-price="{{ $item->price }}"
                                data-description="{{ $item->description }}"
                                data-meal-period="{{ $item->meal_period }}"></option>
                    @endforeach
                </datalist>
            </div>

            <div class="form-group">
                <label for="description">Description <span style="color:var(--muted); font-weight:400">(optional)</span></label>
                <textarea
                    name="description"
                    id="description"
                    rows="2"
                    placeholder="with lemon butter and seasonal vegetables"
                    class="form-control @error('description') is-invalid @enderror"
                    style="resize:vertical;"
                >{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Save menu
            </button>
        </form>
    </div>
</div>
@endif

{{-- ── Today's menu List ── --}}
<div class="card">
    <div class="card-header">
        <span>📋 Menu for {{ \Carbon\Carbon::parse($date)->format('l, M j') }}</span>
        <span style="color:var(--muted); font-size:.85rem;">
            {{ $menuItems->flatten()->count() }} item(s)
        </span>
    </div>

    @if($menuItems->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🍽</div>
            <p style="font-weight:600;">No menu yet for this day.</p>
            <p style="font-size:.9rem; margin-top:6px;">Use the form above to add your first one.</p>
        </div>
    @else
        @foreach($mealPeriods as $key => $label)
            @if($menuItems->has($key))
                <div class="section-label ">{{ $label }}</div>
                <div style="padding: 10px 20px;">
                    @foreach($menuItems[$key] as $menuItem)
                        <div class="menu-item">
                            <div class="menu-info">
                                <div class="menu-name">
                                    {{ ucfirst($menuItem->name) }}
                                    @unless($menuItem->is_available)
                                        <span class="badge badge-sold-out">Sold Out</span>
                                    @endunless
                                </div>
                                @if($menuItem->description)
                                    <div class="menu-desc">{{ $menuItem->description }}</div>
                                @endif
                            </div>
                            <div style="display:flex; flex-direction:column; align-items:flex-end; gap:8px;">
                                <span class="menu-price">{{ $menuItem->formatted_price }}</span>
                                @if($date >= now()->toDateString())
                                    <div class="menu-actions">
                                        {{-- Toggle sold-out — single tap, no page reload needed --}}
                                        <form action="{{ route('admin.menu-items.toggle', $menuItem) }}" method="POST" class="delete-form">
                                            @csrf
                                            <button type="submit" class="btn btn-outline btn-sm btn-icon" title="{{ $menuItem->is_available ? 'Mark sold out' : 'Mark available' }}">
                                                {{ $menuItem->is_available ? '🚫' : '✅' }}
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.menu-items.edit', $menuItem) }}" class="btn btn-outline btn-sm btn-icon" title="Edit">✏️</a>
                                        <form action="{{ route('admin.menu-items.destroy', $menuItem) }}" method="POST" class="delete-form"
                                            onsubmit="return confirm('Remove {{ addslashes($menuItem->name) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline btn-sm btn-icon" title="Delete">🗑</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    @endif
</div>

{{-- ── Copy from another date ── --}}
@if($date >= now()->toDateString())
<div class="card mt-4">
    <div class="card-header">📋 Copy menu from Another Day</div>
    <div class="card-body">
        <p class="text-muted" style="font-size:.9rem; margin-bottom:12px;">
            Running the same menu as a previous day? Copy them in one tap.
        </p>
        <form action="{{ route('admin.menu-items.copy') }}" method="POST">
            @csrf
            <input type="hidden" name="to_date" value="{{ $date }}">
            <div class="form-row">
                <div class="form-group" style="margin-bottom:0">
                    <label for="from_date">Copy from</label>
                    <input type="date" name="from_date" id="from_date" class="form-control"
                           max="{{ \Carbon\Carbon::yesterday()->toDateString() }}">
                </div>
                <div class="form-group" style="margin-bottom:0; display:flex; align-items:flex-end;">
                    <button type="submit" class="btn btn-outline btn-block">Copy menu</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const priceInput = document.getElementById('price');
        const descInput = document.getElementById('description');
        const mealSelect = document.getElementById('meal_period');
        const datalist = document.getElementById('dish-suggestions');

        nameInput.addEventListener('input', function() {
            const val = this.value;
            const options = datalist.options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === val) {
                    // Found a match in suggestions -> auto-fill other fields
                    if (options[i].dataset.price) priceInput.value = options[i].dataset.price;
                    if (options[i].dataset.description) descInput.value = options[i].dataset.description;
                    if (options[i].dataset.mealPeriod) mealSelect.value = options[i].dataset.mealPeriod;
                    break;
                }
            }
        });
    });
</script>

@endsection
