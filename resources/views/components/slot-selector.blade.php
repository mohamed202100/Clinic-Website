@props(['doctors' => [], 'selectedDate' => '', 'selectedDoctor' => ''])

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
    <label for="appointment_date" class="form-label">Appointment Date <span class="text-danger">*</span></label>
    <input type="date" name="appointment_date_input" id="appointment_date_input" 
           class="form-control @error('appointment_date') is-invalid @enderror"
           value="{{ old('appointment_date_input', $selectedDate) }}"
           min="{{ date('Y-m-d') }}" required>
    
    <input type="hidden" name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}">
    
    @error('appointment_date')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="time_slot" class="form-label">Available Time Slots <span class="text-danger">*</span></label>
    <select name="time_slot_selector" id="time_slot_selector" class="form-control" disabled>
        <option value="">-- Select Doctor and Date First --</option>
    </select>
    
    @error('appointment_date')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    
    <div id="loading_slots" class="d-none mt-2">
        <small class="text-muted"><i class="fas fa-spinner fa-spin"></i> Loading available slots...</small>
    </div>
    
    <div id="no_slots" class="alert alert-warning d-none mt-2">
        <i class="fas fa-exclamation-triangle"></i> No available slots for selected date and doctor.
    </div>
</div>

@if(!isset($scripts) || $scripts)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.getElementById('doctor_id');
    const dateInput = document.getElementById('appointment_date_input');
    const timeSlotSelect = document.getElementById('time_slot_selector');
    const hiddenDateTime = document.getElementById('appointment_date');
    const loadingIndicator = document.getElementById('loading_slots');
    const noSlotsMessage = document.getElementById('no_slots');

    function loadAvailableSlots() {
        const doctorId = doctorSelect.value;
        const date = dateInput.value;

        if (!doctorId || !date) {
            timeSlotSelect.innerHTML = '<option value="">-- Select Doctor and Date First --</option>';
            timeSlotSelect.disabled = true;
            return;
        }

        loadingIndicator.classList.remove('d-none');
        timeSlotSelect.disabled = true;
        noSlotsMessage.classList.add('d-none');

        fetch(`{{ url('appointments/available-slots') }}?doctor_id=${doctorId}&date=${date}`)
            .then(response => response.json())
            .then(data => {
                loadingIndicator.classList.add('d-none');
                
                if (data.available_slots && data.available_slots.length > 0) {
                    timeSlotSelect.innerHTML = '';
                    data.available_slots.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot.value;
                        option.textContent = slot.label;
                        timeSlotSelect.appendChild(option);
                    });
                    timeSlotSelect.disabled = false;
                } else {
                    timeSlotSelect.innerHTML = '<option value="">No available slots</option>';
                    timeSlotSelect.disabled = true;
                    noSlotsMessage.classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error loading slots:', error);
                loadingIndicator.classList.add('d-none');
                timeSlotSelect.innerHTML = '<option value="">Error loading slots</option>';
                timeSlotSelect.disabled = true;
            });
    }

    // Update hidden field when time slot changes
    timeSlotSelect.addEventListener('change', function() {
        if (this.value) {
            hiddenDateTime.value = this.value;
        } else {
            hiddenDateTime.value = '';
        }
    });

    // Load slots when doctor or date changes
    doctorSelect.addEventListener('change', loadAvailableSlots);
    dateInput.addEventListener('change', loadAvailableSlots);

    // Load slots on page load if values are pre-selected
    if (doctorSelect.value && dateInput.value) {
        loadAvailableSlots();
    }
});
</script>
@endif
