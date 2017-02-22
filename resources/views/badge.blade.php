<svg xmlns="http://www.w3.org/2000/svg" width="{{ $widths[0] + $widths[1] }}" height="20">
    <linearGradient id="smooth" x2="0" y2="100%">
        <stop offset="0" stop-color="#bbb" stop-opacity=".1"/>
        <stop offset="1" stop-opacity=".1"/>
    </linearGradient>

    <clipPath id="round">
        <rect width="{{ $widths[0] + $widths [1] }}" height="20" rx="3" fill="#fff"/>
    </clipPath>

    <g clip-path="url(#round)">
        <rect width="{{$widths[0]}}" height="20" fill="#555"/>
        <rect x="{{ $widths[0] }}" width="{{ $widths[1] }}" height="20" fill="#4c1"/>
        <rect width="{{ $widths[0] + $widths[1] }}" height="20" fill="url(#smooth)"/>
    </g>

    <g fill="#fff" text-anchor="middle" font-family="DejaVu Sans,Verdana,Geneva,sans-serif" font-size="11">
        <text x="{{ $widths[0] / 2 }}" y="15" fill="#010101" fill-opacity=".3">downloads</text>
        <text x="{{ $widths[0] / 2 }}" y="14">downloads</text>
        <text x="{{$widths[0]+$widths[1]/2-1}}" y="15" fill="#010101" fill-opacity=".3">{{ $text }}</text>
        <text x="{{$widths[0]+$widths[1]/2-1}}" y="14">{{ $text }}</text>
    </g>
</svg>