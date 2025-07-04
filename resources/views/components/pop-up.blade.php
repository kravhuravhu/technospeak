<style>
    #generic-modal {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        padding: 40px;
        width: 90%;
        max-width: 500px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-header h2 {
        margin-bottom: 20px;
    }

    .modal-footer button {
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        font-weight: 500;
        cursor: pointer;
        font-family: 'Roboto', sans-serif;
        margin: 0 10px;
    }

    .btn-primary {
        background-color: #38b6ff;
        color: white;
    }

    .btn-secondary {
        background-color:rgb(158, 60, 60);
        color: white;
    }
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        width: 400px;
        text-align: center;
    }

    .modal-button {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #38b6ff;
        border: none;
        color: white;
        cursor: pointer;
        border-radius: 8px;
    }

    .modal-button.cancel {
        background-color: #ff4747;
    }
</style>

<div id="generic-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <header class="modal-header">
            <h2 id="modal-title">Modal Title</h2>
        </header>
        <div id="modal-body" class="modal-body">
            <!-- content -->
        </div>
        <footer class="modal-footer">
            <button id="modal-confirm-btn" class="btn btn-primary">Confirm</button>
            <button id="modal-cancel-btn" class="btn btn-secondary">Cancel</button>
        </footer>
    </div>
</div>
