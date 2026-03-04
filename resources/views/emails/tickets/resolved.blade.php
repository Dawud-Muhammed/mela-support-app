<x-mail::message>
# 🟢 Case Resolved: {{ $ticket->category->name }}

Hello **{{ $ticket->user->name }}**,

Good news! The campus technician assigned to your case (**{{ $ticket->tracking_id }}**) has marked the issue as **Resolved**.

### Case Details:
- **Location:** {{ $ticket->building }}
- **Issue:** {{ $ticket->subject }}
- **Technician:** {{ $ticket->assignedTechnician ? $ticket->assignedTechnician->name : 'Campus Staff' }}

### We Need Your Verification!
Please log in to the BiT Support Portal to review the technician's "After" photo evidence. If everything looks good, you can officially close the ticket. If the issue is still broken, you can reject it.

<x-mail::button :url="route('tickets.show', $ticket->id)">
Review & Close Case
</x-mail::button>

Thank you for helping keep our campus running,<br>
**Mela Support: BiT Facility Management**
</x-mail::message>