@extends('insurance.layout')

@section('content')
<form method="POST" action="{{ route('insurance.step.process', ['step' => $currentStep]) }}" id="step2Form">
    @csrf
    
    <div class="step-title">
        Address Information
    </div>
    
   

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        <label for="address" class="form-label">Full Address</label>
        <textarea 
            class="form-control" 
            id="address" 
            name="address" 
            rows="6"
            placeholder="Enter your complete address here...&#10;&#10;Example:&#10;Flat 12, 2nd Floor&#10;Building A, House 123&#10;Road 251, Block 428"
            style="resize: vertical; min-height: 150px;">{{ old('address', $formData['address'] ?? '') }}</textarea>
        @error('address')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="button-group">
        <a href="{{ route('insurance.step', ['step' => $currentStep - 1]) }}" class="btn btn-secondary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M15 18L9 12L15 6"/>
            </svg>
            Previous Step
        </a>
        <button type="submit" class="btn btn-primary">
            Next Step
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 18L15 12L9 6"/>
            </svg>
        </button>
    </div>
</form>


@endsection
