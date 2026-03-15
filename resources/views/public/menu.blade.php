<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#121212">

    <title>{{ $restaurantName }}</title>
    <style>
        /* Base Reset & Variables */
        :root {
            --charcoal: #121212;
            --surface: #1e1e1e;
            --burnt-orange: #cc5500;
            --golden-yellow: #ffbf00;
            --text-main: #e0e0e0;
            --text-muted: #a0a0a0;
        }

        body {
            background-color: var(--charcoal);
            color: var(--text-main);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Header Styling */
        header {
            text-align: center;
            margin-bottom: 3rem;
        }

        header h1 {
            color: var(--burnt-orange);
            font-size: 2.5rem;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .date-badge {
            display: inline-block;
            background-color: var(--surface);
            color: var(--burnt-orange);
            padding: 0.4rem 1.2rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid var(--burnt-orange);
            text-transform: uppercase;
        }

        /* Menu Categories */
        .category-title {
            font-size: 1.2rem;
            font-weight: 300;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-top: 2.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 0.5rem;
        }

        /* Flexbox Menu Rows */
        .menu-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .item-info {
            flex: 1;
            padding-right: 1rem;
        }

        .item-name {
            font-size: 1.1rem;
            font-weight: 600;
            display: block;
            margin-bottom: 0.2rem;
        }

        .item-description {
            font-size: 0.9rem;
            color: var(--text-muted);
            display: block;
        }

        .item-price {
            color: var(--golden-yellow);
            font-weight: 800;
            font-size: 1.1rem;
            white-space: nowrap;
        }

        /* Subtle divide for list items */
        .menu-list {
            list-style: none;
            padding: 0;
        }

        /* ── Footer ── */

        footer {
            text-align: center;
            padding: 24px;
            color: var(--muted);
            font-size: .8rem;
            border-top: 1px solid var(--border);
            margin-top: 24px;
        }
    </style>

</head>

<body>
    <div class="container">
        <header>
            <h1>🍽 {{ $restaurantName }}</h1>
            <span class="date-badge">{{ now()->format('F d, Y') }}</span>
            <p class="header-sub">Today's Menu Items</p>
        </header>

        <main>
            @if($isEmpty)
                <div class="empty">
                    <div class="empty-icon">🕐</div>
                    <p style="font-weight:600; font-size:1.1rem;">No menu items have been posted yet.</p>
                    <p style="margin-top:8px;">Check back soon !</p>
                </div>
            @else
                @foreach($mealPeriods as $key => $label)
                    @if($menuItems->has($key))
                        <section>
                            <h2 class="category-title">{{ $label }}</h2>
                            <div class="menu-list">
                                @foreach($menuItems[$key] as $menuItem)
                                    <div class="menu-item">
                                        <div class="item-info">
                                            <span class="item-name">{{ ucfirst($menuItem->name) }}</span>
                                            @if($menuItem->description)
                                                <span class="item-description">{{ $menuItem->description }}</span>
                                            @endif
                                        </div>
                                        <div class="item-price">{{ $menuItem->formatted_price }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                @endforeach
            @endif
        </main>

        <footer>
            Specials menu daily
        </footer>
    </div>

</body>

</html>