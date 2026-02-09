@props(['followups' => []])

<div class="followup-reminder-modal" id="followupReminderModal" style="display: none;">
    <div class="followup-modal-overlay"></div>
    <div class="followup-modal-container">
        <div class="followup-modal-header">
            <h2 class="followup-modal-title">Follow-Up Reminders</h2>
            <button class="followup-modal-close-btn" onclick="closeFollowupModal()">
                <img class="followup-modal-close-icon" src="{{ asset('icon0.svg') }}" alt="Close">
            </button>
        </div>
        
        <div class="followup-modal-content">
            @php
                // Default followup data if none provided
                $defaultFollowups = [
                    [
                        'name' => 'Dr. Sarah Johnson',
                        'priority' => 'high',
                        'priority_text' => 'High',
                        'task' => 'Follow up on ultrasound quote',
                        'date' => 'Today',
                        'date_icon' => 'icon1.svg',
                        'bg_color' => '#fef2f2',
                        'border_color' => '#ffc9c9',
                        'badge_bg' => '#ffe2e2',
                        'text_color' => '#c10007'
                    ],
                    [
                        'name' => 'Michael Chen',
                        'priority' => 'medium',
                        'priority_text' => 'Medium',
                        'task' => 'Send updated pricing',
                        'date' => 'Tomorrow',
                        'date_icon' => 'icon2.svg',
                        'bg_color' => '#fefce8',
                        'border_color' => '#fff085',
                        'badge_bg' => '#fef9c2',
                        'text_color' => '#a65f00'
                    ],
                    [
                        'name' => 'Emily Rodriguez',
                        'priority' => 'low',
                        'priority_text' => 'Low',
                        'task' => 'Schedule demo call',
                        'date' => 'In 2 days',
                        'date_icon' => 'icon3.svg',
                        'bg_color' => '#eff6ff',
                        'border_color' => '#bedbff',
                        'badge_bg' => '#dbeafe',
                        'text_color' => '#1447e6'
                    ]
                ];
                
                $followups = !empty($followups) ? $followups : $defaultFollowups;
            @endphp
            
            @foreach($followups as $followup)
                <div class="followup-item priority-{{ $followup['priority'] }}"
                     style="background: {{ $followup['bg_color'] }}; border-color: {{ $followup['border_color'] }};">
                    <div class="followup-item-header">
                        <h3 class="followup-name">{{ $followup['name'] }}</h3>
                        <span class="followup-priority-badge" 
                              style="background: {{ $followup['badge_bg'] }}; 
                                     border-color: {{ $followup['border_color'] }};
                                     color: {{ $followup['text_color'] }};">
                            {{ $followup['priority_text'] }}
                        </span>
                    </div>
                    
                    <p class="followup-task">{{ $followup['task'] }}</p>
                    
                    <div class="followup-date">
                        <img class="followup-date-icon" src="{{ asset($followup['date_icon']) }}" alt="Date">
                        <span class="followup-date-text">{{ $followup['date'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="followup-modal-footer">
            <button class="followup-btn-secondary" onclick="configureTriggers()">
                Configure Triggers
            </button>
            <button class="followup-btn-primary" onclick="closeFollowupModal()">
                Close
            </button>
        </div>
    </div>
</div>

<script>
// Make sure functions are globally accessible
if (typeof window.openFollowupModal === 'undefined') {
    window.openFollowupModal = function() {
        const modal = document.getElementById('followupReminderModal');
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            console.log('Modal opened from component script');
        }
    };
}

if (typeof window.closeFollowupModal === 'undefined') {
    window.closeFollowupModal = function() {
        const modal = document.getElementById('followupReminderModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    };
}

if (typeof window.configureTriggers === 'undefined') {
    window.configureTriggers = function() {
        alert('Configure Triggers functionality would open settings page.');
        closeFollowupModal();
    };
}

// Initialize modal if it exists on page load
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('followupReminderModal');
    if (modal) {
        console.log('Followup modal component loaded');
        
        // Add click outside to close functionality
        modal.addEventListener('click', function(e) {
            if (e.target.classList.contains('followup-modal-overlay')) {
                closeFollowupModal();
            }
        });
        
        // Add escape key to close functionality
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.style.display === 'block') {
                closeFollowupModal();
            }
        });
    }
});
</script>