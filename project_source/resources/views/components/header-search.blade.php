@props(['title'])

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tabler/icons@1.74.0/icons-react/dist/index.umd.min.js"></script>
</head>

<div class="header-container">
    <h1 class="title">{{ $title }}</h1>
    <div class="header-controls">
        {{-- Button filter --}}
        <div class="filter-icon" onclick="toggleFilter()">
            <i class="ti ti-adjustments-horizontal"></i>
        </div>

        {{-- Search bar --}}
        <div class="search-bar" style="margin-bottom: -15px">
            <form method="GET" action="{{ route('students.register-room.list') }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search rooms..."
                    class="search-input" aria-label="Search rooms">
            </form>
        </div>
    </div>
</div>

<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 40px auto 20px auto;
        max-width: 1200px;
    }

    .header-controls {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .filter-container {
        background: white;
        padding: 24px;
        border-radius: 24px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .filter-icon {
        background: white;
        padding: 8px;
        border-radius: 10px;
        cursor: pointer;
        border: 2px solid #cbd4f3;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        height: 42px;
        width: 42px;
    }

    .filter-icon i {
        font-size: 20px;
        color: #757575;
    }

    .filter-icon:hover {
        background: #f3f4f6;
        border-color: #2563eb;
    }

    .search-bar {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-input {
        padding: 8px 16px;
        border: 2px solid #cbd4f3;
        border-radius: 10px;
        font-size: 0.875rem;
        outline: none;
        width: 300px;
        height: 42px;
        box-sizing: border-box;
    }

    .search-input:hover {
        border-color: #2563eb;
    }
</style>
