@extends('layouts.admin')

@section('title', 'QR Code')

@section('content')

<div class="card">
    <div class="card-header">Table QR Code</div>
    <div class="card-body text-center">
        <p class="text-muted" style="margin-bottom:20px;">
            Print this and place it on each table. Customers scan it to see today's menu.
            <strong>You never need to reprint it</strong> — it always shows today's menu.
        </p>

        <div class="qr-wrapper" style="background:#fff; display:inline-block; padding:20px; border-radius:12px; border:2px solid var(--border); max-width: 100%; box-sizing: border-box;">
            <style>
                .qr-wrapper svg { max-width: 100%; height: auto; }
            </style>
            {!! $qr !!}
        </div>

        <p style="margin-top:12px; font-size:.85rem; color:var(--muted); word-break:break-all;">
            {{ $menuUrl }}
        </p>

        <div style="margin-top:20px; display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
            <a href="{{ route('admin.qr.download') }}" class="btn btn-primary">
                 Download 
            </a>
            <a href="{{ $menuUrl }}" target="_blank" class="btn btn-outline">
                Preview customer view 
            </a>
        </div>
    </div>
</div>

@endsection