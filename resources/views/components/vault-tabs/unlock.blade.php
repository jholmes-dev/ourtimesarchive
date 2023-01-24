<div class="tab-pane fade" id="unlock" role="tabpanel" aria-labelledby="unlockTab">

    <p>Ready to crack your vault? Use one of the options below to initiate a <em>vault unlock</em>. Not sure what a vault unlock is? <a href="#">Click here to find out</a>.</p>

    <div class="mt-5 row gy-4 justify-content-around">

        <div class="col-12 col-md-6 unlock-local-wrapper text-center">
            <div class="unlock-local">
                <div class="unlock-icon">
                    <i class="bi bi-person-fill ul1"></i>
                    <i class="bi bi-person-fill ul2"></i>
                    <i class="bi bi-person-fill ul3"></i>
                    <i class="bi bi-person-fill ul4"></i>
                    <i class="bi bi-laptop ul5"></i>
                </div>
                <h5>Local Unlock</h5>
                <a href="#" class="stretched-link"  onclick="event.preventDefault();document.getElementById('local-unlock').submit();"></a>
            </div>

            <form class="d-none" id="local-unlock" action="{{ route('vault.unlock.local', $vault->id) }}" method="POST">
                @csrf
            </form>
        </div>
        <div class="col-12 col-md-6 unlock-remote-wrapper text-center">
            <div class="unlock-remote">
                <div class="unlock-icon">
                    <i class="bi bi-person-workspace ul1"></i>
                    <i class="bi bi-person-workspace ul2"></i>
                    <i class="bi bi-person-workspace ul3"></i>
                    <i class="bi bi-person-workspace ul4"></i>
                </div>
                <h5>Remote Unlock</h5>
            </div>
            <h6>Feature in progress</h6>
        </div>

    </div>
</div>