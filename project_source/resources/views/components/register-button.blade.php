<button class="change-button">Register</button>

<script>
    const changeButton = document.querySelector('.change-button');
    changeButton.addEventListener('click', () => {
        alert('Register room successfully!');
    });
</script>

{{-- <div class="confirm-regis hidden">
    <h2>Are you sure to register this room?</h2>
    <div class="button-container">
        <button class="no-btn" onclick="closeConfirm()">No</button>
        <button class="yes-btn" onclick="showConfirmInfoContainer()">Yes</button>
    </div>
</div>

<div class="confirm-info-container">
    <form class="confirm-info-form">
        <div class="confirm-info-header">
            <h2> ROOM APPLICATION </h2>
        </div>
        <div class="confirm-info-body">
            <div class="left-column">
                <div class="confirm-info-field">
                    <label for="dorm-id">Dorm ID</label>
                    <input type="text" id="dorm-id" readonly>
                </div>
                <div class="confirm-info-field">
                    <label for="full-name">Full name</label>
                    <input type="text" id="full-name" readonly>
                </div>
                <div class="confirm-info-field">
                    <label for="room-id">Room ID</label>
                    <input type="text" id="room-id" readonly>
                </div>
                <div class="confirm-info-field">
                    <label for="building-id">Building ID</label>
                    <input type="text" id="building-id" readonly>
                </div>
                <div class="confirm-info-field">
                    <label for="floor">Floor</label>
                    <input type="text" id="floor" readonly>
                </div>
                <div class="confirm-info-field">
                    <label for="start-date">Start date</label>
                    <input type="date" id="start-date">
                </div>

            </div>
            <div class="right-column">
                <div class="confirm-info-field">
                    <label for="student-id">Student ID</label>
                    <input type="text" id="student-id" readonly>
                </div>
                <div class="confirm-info-field">
                    <label for="gender">Gender</label>
                    <input type="text" id="gender" readonly>
                </div>
                <div class="confirm-info-field">
                    <label for="price">Price</label>
                    <input type="text" id="price" readonly>
                </div>
                <div class="confirm-info-field">
                    <label for="room-type">Room type</label>
                    <input type="text" id="room-type" readonly>
                </div>
                <div class="confirm-info-field">
                    <label for="capacity">Capacity</label>
                    <input type="text" id="capacity" readonly>
                </div>
                <div class="confirm-info-field">
                    <label for="duration">Duration</label>
                    <select id="duration" readonly>
                        <option value="3">3 months</option>
                        <option value="6">6 months</option>
                        <option value="9">9 months</option>
                        <option value="12">12 months</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="confirm-info-footer">
            <button type="submit" onclick="showSuccessPanel()">Confirm</button>
        </div>
    </form>
</div>


<div class="success-panel hidden">
    <div class="success-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="156" height="156" viewBox="0 0 156 156" fill="none">
            <path
                d="M77.6144 141.082C65.9713 141.093 54.5071 138.218 44.2472 132.714C33.9873 127.209 25.2518 119.248 18.8219 109.541C18.4666 109.008 18.2197 108.411 18.0954 107.782C17.9711 107.154 17.9718 106.507 18.0974 105.879C18.223 105.251 18.4711 104.654 18.8275 104.122C19.184 103.589 19.6417 103.132 20.1747 102.777C20.7077 102.422 21.3054 102.175 21.9337 102.051C22.5621 101.926 23.2088 101.927 23.8369 102.053C24.465 102.178 25.0622 102.426 25.5944 102.783C26.1266 103.139 26.5834 103.597 26.9388 104.13C35.3419 116.758 48.1886 125.762 62.9257 129.352C77.6627 132.943 93.2113 130.857 106.481 123.51C119.751 116.163 129.771 104.092 134.55 89.696C139.328 75.3002 138.515 59.6334 132.273 45.8094C126.03 31.9853 114.815 21.016 100.856 15.0814C86.8969 9.14686 71.216 8.68152 56.9296 13.7779C42.6432 18.8742 30.7972 29.1592 23.746 42.5887C16.6947 56.0183 14.9543 71.6093 18.8706 86.2631C19.1395 87.495 18.9205 88.7831 18.2599 89.857C17.5992 90.9309 16.5481 91.7071 15.3274 92.0225C14.1066 92.3379 12.8111 92.1681 11.7129 91.5487C10.6146 90.9293 9.7991 89.9085 9.4375 88.7006C7.84219 82.7537 7.02289 76.6253 7 70.4681C7.01446 56.5226 11.1621 42.8943 18.9188 31.305C26.6755 19.7158 37.6933 10.6857 50.58 5.35567C63.4668 0.0256401 77.6442 -1.36515 91.3211 1.35903C104.998 4.08321 117.56 10.8001 127.421 20.6611C137.282 30.5221 143.999 43.0846 146.723 56.7614C149.448 70.4383 148.057 84.6157 142.727 97.5025C137.397 110.389 128.367 121.407 116.777 129.164C105.188 136.92 91.5599 141.068 77.6144 141.082Z"
                fill="#2F6BFF" />
            <path
                d="M107.905 49.1428C109.573 50.7243 109.639 53.3455 108.05 55.0045L70.9885 93.7135C70.5992 94.12 70.1308 94.4437 69.612 94.6648C69.0931 94.886 68.5345 95 67.9701 95C67.4056 95 66.847 94.886 66.3281 94.6648C65.8093 94.4437 65.341 94.12 64.9516 93.7135L46.4238 74.359C46.03 73.9679 45.7189 73.5024 45.5088 72.9899C45.2987 72.4774 45.1939 71.9282 45.2005 71.3747C45.2071 70.8213 45.325 70.2747 45.5472 69.7673C45.7694 69.2599 46.0915 68.8018 46.4945 68.4201C46.8975 68.0385 47.3731 67.7409 47.8935 67.545C48.4139 67.349 48.9684 67.2587 49.5245 67.2793C50.0805 67.2999 50.6267 67.431 51.131 67.6649C51.6353 67.8987 52.0874 68.2307 52.4608 68.6411L67.9701 84.8436L102.013 49.2866C102.775 48.4905 103.824 48.0282 104.929 48.0012C106.034 47.9743 107.104 48.3849 107.905 49.1428Z"
                fill="#2F6BFF" />
        </svg>
    </div>
    <h2>Register room successfully!</h2>
    <p>Please pay the registration invoice within 15 days</p>
    <button class="continue-btn" onclick="closeAllPanels()">Continue</button>
</div>

<div class="overlay2"></div> --}}


