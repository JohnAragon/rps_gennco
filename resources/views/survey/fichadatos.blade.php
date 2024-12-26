<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ficha de datos') }}</div>
                     <div class="card-body">
                        <form method="POST" action="{{ route('submit.form') }}">
                            @csrf
                            <!-- Text Input -->
                            <input type="text" name="name" placeholder="Full Name" required>

                            <!-- Email Input -->
                            <input type="email" name="email" placeholder="Email" required>

                            <!-- Select Dropdown -->
                            <select name="department">
                                @foreach($departments as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>

                            <!-- Date Input -->
                            <input type="date" name="birthdate" required>

                            <!-- Radio Buttons -->
                            <label>
                                <input type="radio" name="subscription" value="newsletter"> Subscribe to Newsletter
                            </label>

                            <!-- Checkboxes -->
                            <label>
                                <input type="checkbox" name="interests[]" value="sports"> Sports
                            </label>
                            <label>
                                <input type="checkbox" name="interests[]" value="tech"> Technology
                            </label>

                            <!-- Textarea -->
                            <textarea name="comments" placeholder="Additional Comments"></textarea>

                            <button type="submit">Submit</button>
                        </form>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
