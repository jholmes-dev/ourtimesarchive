<div class="tab-pane fade" id="leave" role="tabpanel" aria-labelledby="leaveTab">
    
    <p>Once you leave a vault <strong>you cannot return</strong>. All of your entries (both locked and unlocked), images, and any other data associated with the vault will be <strong>permanently deleted</strong>. If you are the last vault member, the vault will also be permanently deleted.</p>
    <p>Please consider carefully before continuing, as <strong>this action cannot be undone, and you cannot rejoin a vault once you leave</strong>.</p>

    <div class="my-5 text-center">
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#leaveModal">Leave Vault</button>
    </div>

</div>

<div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="leaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('vault.leave', $vault->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="leaveModalLabel">Leave Vault Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you'd like to leave <strong>{{ $vault->name }}</strong>?</p>
                    <p>This action cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Nevermind</button>
                    <input type="submit" class="btn btn-danger" value="Yes, Leave Vault">
                </div>
            </form>
        </div>
    </div>
</div>