<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password with Strength Meter -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            oninput="checkPasswordStrength(this.value)" />
            
            <!-- Strength Meter -->
            <div class="mt-3">
                <div class="flex gap-1">
                    <div id="strength-bar-1" class="h-2 flex-1 bg-gray-200 rounded transition-colors duration-300"></div>
                    <div id="strength-bar-2" class="h-2 flex-1 bg-gray-200 rounded transition-colors duration-300"></div>
                    <div id="strength-bar-3" class="h-2 flex-1 bg-gray-200 rounded transition-colors duration-300"></div>
                    <div id="strength-bar-4" class="h-2 flex-1 bg-gray-200 rounded transition-colors duration-300"></div>
                </div>
                <p id="strength-text" class="text-sm mt-2 font-medium"></p>
                
                <!-- Requirements Checklist -->
                <div class="mt-3 space-y-1">
                    <p class="text-xs font-semibold text-gray-700 mb-2">Password must contain:</p>
                    <div id="req-length" class="text-xs text-gray-500 flex items-center gap-2">
                        <span class="icon">✗</span>
                        <span>At least 8 characters</span>
                    </div>
                    <div id="req-uppercase" class="text-xs text-gray-500 flex items-center gap-2">
                        <span class="icon">✗</span>
                        <span>One uppercase letter (A-Z)</span>
                    </div>
                    <div id="req-lowercase" class="text-xs text-gray-500 flex items-center gap-2">
                        <span class="icon">✗</span>
                        <span>One lowercase letter (a-z)</span>
                    </div>
                    <div id="req-number" class="text-xs text-gray-500 flex items-center gap-2">
                        <span class="icon">✗</span>
                        <span>One number (0-9)</span>
                    </div>
                    <div id="req-special" class="text-xs text-gray-500 flex items-center gap-2">
                        <span class="icon">✗</span>
                        <span>One special character (!@#$%^&*)</span>
                    </div>
                </div>
            </div>
            
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
    function checkPasswordStrength(password) {
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };
        
        // Update requirement checkmarks
        updateRequirement('req-length', requirements.length);
        updateRequirement('req-uppercase', requirements.uppercase);
        updateRequirement('req-lowercase', requirements.lowercase);
        updateRequirement('req-number', requirements.number);
        updateRequirement('req-special', requirements.special);
        
        // Calculate strength score
        const score = Object.values(requirements).filter(Boolean).length;
        
        // Update visual meter
        const bars = ['strength-bar-1', 'strength-bar-2', 'strength-bar-3', 'strength-bar-4'];
        const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
        const texts = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
        const textColors = ['text-red-600', 'text-orange-600', 'text-yellow-600', 'text-green-600', 'text-green-700'];
        
        bars.forEach((bar, index) => {
            const element = document.getElementById(bar);
            element.className = 'h-2 flex-1 rounded transition-colors duration-300 ';
            if (index < score - 1 && score > 1) {
                element.className += colors[Math.min(score - 2, 3)];
            } else {
                element.className += 'bg-gray-200';
            }
        });
        
        const strengthText = document.getElementById('strength-text');
        if (score > 0) {
            strengthText.textContent = `Password Strength: ${texts[score - 1]}`;
            strengthText.className = `text-sm mt-2 font-medium ${textColors[score - 1]}`;
        } else {
            strengthText.textContent = '';
        }
    }

    function updateRequirement(id, met) {
        const element = document.getElementById(id);
        const icon = element.querySelector('.icon');
        
        if (met) {
            element.className = 'text-xs text-green-600 flex items-center gap-2 font-medium';
            icon.textContent = '✓';
        } else {
            element.className = 'text-xs text-gray-500 flex items-center gap-2';
            icon.textContent = '✗';
        }
    }
    </script>
</x-guest-layout>