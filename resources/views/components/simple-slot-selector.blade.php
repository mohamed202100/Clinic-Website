@props(['doctors' => [], 'selectedDate' => '', 'selectedDoctor' => '', 'appointmentId' => null, 'currentTime' => ''])

<div class="mb-3">
    <label for="doctor_id" class="form-label">Doctor <span class="text-danger">*</span></label>
    <select name="doctor_id" id="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror" required>
        <option value="">-- Select Doctor --</option>
        @foreach($doctors as $doctor)
            <option value="{{ $doctor->id }}" {{ old('doctor_id', $selectedDoctor) == $doctor->id ? 'selected' : '' }}>
                {{ $doctor->name }} 
                @if($doctor->specialization) - {{ $doctor->specialization }} @endif
            </option>
        @endforeach
    </select>
    @error('doctor_id')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="appointment_date" class="form-label">Appointment Date & Time <span class="text-danger">*</span></label>
    <div class="row">
        <div class="col-md-6">
            <input type="date" name="appointment_date_date" id="appointment_date_date" 
                   class="form-control @error('appointment_date') is-invalid @enderror"
                   value="{{ old('appointment_date_date', $selectedDate) }}"
                   min="{{ date('Y-m-d') }}" required>
        </div>
        <div class="col-md-6">
            <select name="appointment_time" id="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" required>
                <option value="">-- Select Time --</option>
                @php
                    $currentTimeValue = old('appointment_time', $currentTime);
                @endphp
                <option value="08:00" {{ $currentTimeValue == '08:00' ? 'selected' : '' }}>8:00 AM</option>
                <option value="08:30" {{ $currentTimeValue == '08:30' ? 'selected' : '' }}>8:30 AM</option>
                <option value="09:00" {{ $currentTimeValue == '09:00' ? 'selected' : '' }}>9:00 AM</option>
                <option value="09:30" {{ $currentTimeValue == '09:30' ? 'selected' : '' }}>9:30 AM</option>
                <option value="10:00" {{ $currentTimeValue == '10:00' ? 'selected' : '' }}>10:00 AM</option>
                <option value="10:30" {{ $currentTimeValue == '10:30' ? 'selected' : '' }}>10:30 AM</option>
                <option value="11:00" {{ $currentTimeValue == '11:00' ? 'selected' : '' }}>11:00 AM</option>
                <option value="11:30" {{ $currentTimeValue == '11:30' ? 'selected' : '' }}>11:30 AM</option>
                <option value="13:00" {{ $currentTimeValue == '13:00' ? 'selected' : '' }}>1:00 PM</option>
                <option value="13:30" {{ $currentTimeValue == '13:30' ? 'selected' : '' }}>1:30 PM</option>
                <option value="14:00" {{ $currentTimeValue == '14:00' ? 'selected' : '' }}>2:00 PM</option>
                <option value="14:30" {{ $currentTimeValue == '14:30' ? 'selected' : '' }}>2:30 PM</option>
                <option value="15:00" {{ $currentTimeValue == '15:00' ? 'selected' : '' }}>3:00 PM</option>
                <option value="15:30" {{ $currentTimeValue == '15:30' ? 'selected' : '' }}>3:30 PM</option>
                <option value="16:00" {{ $currentTimeValue == '16:00' ? 'selected' : '' }}>4:00 PM</option>
                <option value="16:30" {{ $currentTimeValue == '16:30' ? 'selected' : '' }}>4:30 PM</option>
                <option value="17:00" {{ $currentTimeValue == '17:00' ? 'selected' : '' }}>5:00 PM</option>
            </select>
        </div>
    </div>
    
    <!-- Hidden field for combined date-time -->
    <input type="hidden" name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}">
    
    @error('appointment_date')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    @error('appointment_time')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('appointment_date_date');
    const timeSelect = document.getElementById('appointment_time');
    const hiddenDateTime = document.getElementById('appointment_date');
    const doctorSelect = document.getElementById('doctor_id');
    
    // Fetch existing appointments to disable unavailable slots
    function updateAvailableSlots() {
        const doctorId = doctorSelect.value;
        const date = dateInput.value;
        
        if (!doctorId || !date) {
            return;
        }
        
        // Fetch existing appointments for this doctor and date
        fetch(`{{ url('appointments/get-conflicts') }}?doctor_id=${doctorId}&date=${date}&appointment_id={{ $appointmentId }}`)
            .then(response => response.json())
            .then(data => {
                // Reset all options
                Array.from(timeSelect.options).forEach(option => {
                    if (option.value) {
                        option.disabled = false;
                        option.style.color = '';
                    }
                });
                
                // Disable conflict times
                if (data.conflicts && data.conflicts.length > 0) {
                    data.conflicts.forEach(conflict => {
                        const conflictTime = conflict.split(':').slice(0, 2).join(':');
                        const option = timeSelect.querySelector(`option[value="${conflictTime}"]`);
                        if (option) {
                            option.disabled = true;
                            option.style.color = '#999';
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error checking conflicts:', error);
            });
    }
    
    // Update datetime when date or time changes
    function updateDateTime() {
        const date = dateInput.value;
        const time = timeSelect.value;
        
        if (date && time) {
            hiddenDateTime.value = `${date}T${time}`;
            updateAvailableSlots();
        } else {
            hiddenDateTime.value = '';
        }
    }
    
    // Event listeners
    dateInput.addEventListener('change', updateDateTime);
    timeSelect.addEventListener('change', updateDateTime);
    doctorSelect.addEventListener('change', updateAvailableSlots);
    
    // Initial load
    updateDateTime();
    
    // If editing an existing appointment, set the current time
    @if(isset($appointmentId) && $appointmentId)
        let currentAppointmentTime = "{{ old('appointment_time') }}";
        if (!currentAppointmentTime) {
            // Get from URL or form if needed
            currentAppointmentTime = "{{ request('current_time', '') }}";
        }
        
        if (currentAppointmentTime) {
            const timeOption = timeSelect.querySelector(`option[value="${currentAppointmentTime}"]`);
            if (timeOption) {
                timeOption.selected = true;
                updateDateTime();
            }
        }
    @endif
});
</script>
