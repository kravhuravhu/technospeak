@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Settings</h1>
        <p>Manage system configuration</p>
    </div>
</div>

<div class="form-card">
    <form action="{{ route('content-manager.settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <h3 style="margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid #edf2f7;">
            General Settings
        </h3>
        
        <div class="form-row">
            <div class="form-group">
                <label for="site_name" class="form-label">Site Name</label>
                <input type="text" id="site_name" name="site_name" class="form-control" 
                       value="{{ old('site_name', $settings->site_name ?? 'TechnoSpeak') }}">
            </div>
            
            <div class="form-group">
                <label for="site_email" class="form-label">Site Email</label>
                <input type="email" id="site_email" name="site_email" class="form-control" 
                       value="{{ old('site_email', $settings->site_email ?? 'info@technospeak.com') }}">
            </div>
        </div>
        
        <div class="form-group">
            <label for="site_description" class="form-label">Site Description</label>
            <textarea id="site_description" name="site_description" class="form-control" rows="3">{{ old('site_description', $settings->site_description ?? '') }}</textarea>
        </div>
        
        <h3 style="margin: 2rem 0 1.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid #edf2f7;">
            Payment Settings
        </h3>
        
        <div class="form-row">
            <div class="form-group">
                <label for="currency" class="form-label">Currency</label>
                <select id="currency" name="currency" class="form-control">
                    <option value="USD" {{ old('currency', $settings->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>US Dollar ($)</option>
                    <option value="EUR" {{ old('currency', $settings->currency ?? 'USD') == 'EUR' ? 'selected' : '' }}>Euro (€)</option>
                    <option value="GBP" {{ old('currency', $settings->currency ?? 'USD') == 'GBP' ? 'selected' : '' }}>British Pound (£)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="payment_gateway" class="form-label">Payment Gateway</label>
                <select id="payment_gateway" name="payment_gateway" class="form-control">
                    <option value="stripe" {{ old('payment_gateway', $settings->payment_gateway ?? 'stripe') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                    <option value="paypal" {{ old('payment_gateway', $settings->payment_gateway ?? 'stripe') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="stripe_key" class="form-label">Stripe Publishable Key</label>
                <input type="text" id="stripe_key" name="stripe_key" class="form-control" 
                       value="{{ old('stripe_key', $settings->stripe_key ?? '') }}">
            </div>
            
            <div class="form-group">
                <label for="stripe_secret" class="form-label">Stripe Secret Key</label>
                <input type="password" id="stripe_secret" name="stripe_secret" class="form-control" 
                       value="{{ old('stripe_secret', $settings->stripe_secret ?? '') }}">
            </div>
        </div>
        
        <h3 style="margin: 2rem 0 1.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid #edf2f7;">
            Social Media
        </h3>
        
        <div class="form-row">
            <div class="form-group">
                <label for="facebook_url" class="form-label">Facebook</label>
                <div class="input-group">
                    <span class="input-group-text">https://</span>
                    <input type="text" id="facebook_url" name="facebook_url" class="form-control" 
                           value="{{ old('facebook_url', $settings->facebook_url ?? '') }}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="twitter_url" class="form-label">Twitter</label>
                <div class="input-group">
                    <span class="input-group-text">https://</span>
                    <input type="text" id="twitter_url" name="twitter_url" class="form-control" 
                           value="{{ old('twitter_url', $settings->twitter_url ?? '') }}">
                </div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="instagram_url" class="form-label">Instagram</label>
                <div class="input-group">
                    <span class="input-group-text">https://</span>
                    <input type="text" id="instagram_url" name="instagram_url" class="form-control" 
                           value="{{ old('instagram_url', $settings->instagram_url ?? '') }}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="youtube_url" class="form-label">YouTube</label>
                <div class="input-group">
                    <span class="input-group-text">https://</span>
                    <input type="text" id="youtube_url" name="youtube_url" class="form-control" 
                           value="{{ old('youtube_url', $settings->youtube_url ?? '') }}">
                </div>
            </div>
        </div>
        
        <div class="form-group" style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection