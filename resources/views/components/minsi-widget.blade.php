{{-- =========================================================

     MinSI — Asisten Virtual FAQ Prodi Sistem Informasi LPKIA

     ========================================================= --}}

<div id="minsiContainer" style="position: fixed; bottom: 25px; right: 25px; z-index: 99999; font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;">



    <!-- Floating Trigger Button -->

    <button id="minsiToggleBtn" type="button" aria-label="Tanya MinSI" style="

        display: flex;

        align-items: center;

        gap: 10px;

        background: linear-gradient(135deg, #2563eb, #1d4ed8);

        color: white;

        border: none;

        border-radius: 9999px;

        padding: 12px 20px 12px 14px;

        box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.5), 0 8px 10px -6px rgba(37, 99, 235, 0.3);

        cursor: pointer;

        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);

    ">

        <div style="

            width: 38px;

            height: 38px;

            border-radius: 50%;

            background: white;

            color: #2563eb;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 1.15rem;

            position: relative;

        ">

            <i class="fa-solid fa-robot"></i>

            <span style="

                position: absolute;

                top: 0;

                right: 0;

                width: 10px;

                height: 10px;

                background: #10b981;

                border: 2px solid white;

                border-radius: 50%;

            "></span>

        </div>

        <div style="text-align: left;">

            <div style="font-size: 0.88rem; font-weight: 700; line-height: 1.2;">Tanya MinSI</div>

            <div style="font-size: 0.68rem; opacity: 0.88; font-weight: 500;">FAQ & Bantuan Prodi</div>

        </div>

    </button>



    <!-- Chat Widget Window -->

    <div id="minsiWindow" style="

        display: none;

        position: absolute;

        bottom: 75px;

        right: 0;

        width: 375px;

        max-width: calc(100vw - 30px);

        height: 560px;

        max-height: calc(100vh - 120px);

        background: #ffffff;

        border: 1px solid #e2e8f0;

        border-radius: 20px;

        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);

        flex-direction: column;

        overflow: hidden;

        animation: minsiSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);

    ">



        <!-- Chat Header -->

        <div style="

            background: linear-gradient(135deg, #1e40af, #2563eb);

            color: white;

            padding: 16px 18px;

            display: flex;

            align-items: center;

            justify-content: space-between;

        ">

            <div style="display: flex; align-items: center; gap: 12px;">

                <div style="

                    width: 40px;

                    height: 40px;

                    border-radius: 50%;

                    background: white;

                    color: #2563eb;

                    display: flex;

                    align-items: center;

                    justify-content: center;

                    font-size: 1.2rem;

                    box-shadow: 0 2px 8px rgba(0,0,0,0.15);

                ">

                    <i class="fa-solid fa-robot"></i>

                </div>

                <div>

                    <div style="font-weight: 800; font-size: 0.95rem; letter-spacing: -0.01em;">MinSI — Asisten SI</div>

                    <div style="font-size: 0.72rem; color: #bfdbfe; display: flex; align-items: center; gap: 6px;">

                        <span style="width: 7px; height: 7px; background: #34d399; border-radius: 50%; display: inline-block;"></span>

                        Online • Institut Digital Ekonomi LPKIA

                    </div>

                </div>

            </div>



            <div style="display: flex; align-items: center; gap: 6px;">

                <button id="minsiResetBtn" type="button" title="Mulai Ulang Sesi" style="

                    background: rgba(255,255,255,0.15);

                    border: none;

                    color: white;

                    width: 32px;

                    height: 32px;

                    border-radius: 8px;

                    cursor: pointer;

                    display: flex;

                    align-items: center;

                    justify-content: center;

                    font-size: 0.85rem;

                ">

                    <i class="fa-solid fa-rotate-right"></i>

                </button>

                <button id="minsiCloseBtn" type="button" title="Tutup Chat" style="

                    background: rgba(255,255,255,0.15);

                    border: none;

                    color: white;

                    width: 32px;

                    height: 32px;

                    border-radius: 8px;

                    cursor: pointer;

                    display: flex;

                    align-items: center;

                    justify-content: center;

                    font-size: 1.1rem;

                ">

                    &times;

                </button>

            </div>

        </div>



        <!-- Chat Messages Area -->

        <div id="minsiChatBody" style="

            flex: 1;

            padding: 18px 16px;

            overflow-y: auto;

            background: #f8fafc;

            display: flex;

            flex-direction: column;

            gap: 14px;

            scroll-behavior: smooth;

        ">

            <!-- Messages will be injected here via JavaScript -->

        </div>



        <!-- Inactivity / Timeout Bar -->

        <div id="minsiTimerNotice" style="

            display: none;

            background: #fef2f2;

            border-top: 1px solid #fee2e2;

            padding: 8px 14px;

            font-size: 0.72rem;

            color: #dc2626;

            text-align: center;

        ">

            <i class="fa-solid fa-clock"></i> Sesi otomatis berakhir jika tidak ada aktivitas selama 3 menit.

        </div>



    </div>

</div>



<style>

    @keyframes minsiSlideUp {

        from { opacity: 0; transform: translateY(20px) scale(0.95); }

        to { opacity: 1; transform: translateY(0) scale(1); }

    }

    #minsiToggleBtn:hover {

        transform: translateY(-3px) scale(1.02);

        box-shadow: 0 15px 30px -5px rgba(37, 99, 235, 0.6);

    }

    .minsi-bubble {

        padding: 12px 16px;

        border-radius: 16px;

        font-size: 0.86rem;

        line-height: 1.5;

        max-width: 88%;

        word-break: break-word;

    }

    .minsi-bubble-bot {

        background: #ffffff;

        color: #1e293b;

        border: 1px solid #e2e8f0;

        border-bottom-left-radius: 4px;

        align-self: flex-start;

        box-shadow: 0 2px 5px rgba(0,0,0,0.03);

    }

    .minsi-bubble-user {

        background: #2563eb;

        color: #ffffff;

        border-bottom-right-radius: 4px;

        align-self: flex-end;

    }

    .minsi-chip-btn {

        display: block;

        width: 100%;

        text-align: left;

        background: #ffffff;

        border: 1px solid #cbd5e1;

        border-radius: 10px;

        padding: 9px 12px;

        font-size: 0.82rem;

        font-weight: 600;

        color: #1e40af;

        cursor: pointer;

        transition: all 0.2s ease;

        margin-bottom: 6px;

    }

    .minsi-chip-btn:hover {

        background: #eff6ff;

        border-color: #2563eb;

        transform: translateX(3px);

    }

    .minsi-action-btn {

        background: #2563eb;

        color: white;

        border: none;

        border-radius: 8px;

        padding: 9px 16px;

        font-size: 0.84rem;

        font-weight: 700;

        cursor: pointer;

        display: inline-flex;

        align-items: center;

        gap: 6px;

        transition: all 0.2s ease;

    }

    .minsi-action-btn:hover {

        background: #1d4ed8;

    }

    .minsi-form-input {

        width: 100%;

        border: 1px solid #cbd5e1;

        border-radius: 8px;

        padding: 8px 12px;

        font-size: 0.84rem;

        background: #ffffff;

        box-sizing: border-box;

        margin-bottom: 10px;

        color: #0f172a;

    }

    .minsi-form-input:focus {

        outline: none;

        border-color: #2563eb;

        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);

    }



    /* Dark Mode Compatibility */

    html.dark-mode #minsiWindow {

        background: #0d1422;

        border-color: #1e293b;

    }

    html.dark-mode #minsiChatBody {

        background: #080d18;

    }

    html.dark-mode .minsi-bubble-bot {

        background: #111b2d;

        color: #f8fafc;

        border-color: #1e293b;

    }

    html.dark-mode .minsi-chip-btn {

        background: #111b2d;

        color: #93c5fd;

        border-color: #1e293b;

    }

    html.dark-mode .minsi-chip-btn:hover {

        background: #1e293b;

        border-color: #60a5fa;

    }

    html.dark-mode .minsi-form-input {

        background: #111b2d;

        color: #f8fafc;

        border-color: #334155;

    }

    html.dark-mode #minsiTimerNotice {

        background: #2d1515;

        border-color: #451a1a;

        color: #fca5a5;

    }

</style>



<script>

(function() {

    // ── DATA FAQ RESMI PRODI SISTEM INFORMASI LPKIA ───────────────

    const PRODI_DATA = {

        name: 'Sistem Informasi',

        institution: 'Institut Digital Ekonomi LPKIA',

        whatsapp: '+62 851-8870-5108',

        whatsappClean: '6285188705108',

        email: 'prodi.si@lpkia.ac.id'

    };



    const FAQ_LIST = [

        {

            id: 'q1',

            question: 'Kuliah di Sistem Informasi bakal belajar apa aja?',

            answer: 'Di Sistem Informasi, kamu akan belajar bagaimana teknologi bisa digunakan untuk membantu kebutuhan bisnis dan organisasi. Materinya berkaitan dengan sistem informasi, pengembangan solusi digital, data, teknologi, dan hal-hal yang berhubungan dengan kebutuhan dunia kerja.'

        },

        {

            id: 'q2',

            question: 'SI dan Teknik Informatika, sebenarnya bedanya apa?',

            answer: 'Secara umum, Sistem Informasi lebih menggabungkan teknologi dengan kebutuhan bisnis dan organisasi. Jadi, selain belajar teknologi, kamu juga akan melihat bagaimana sistem bisa digunakan untuk membantu proses dan kebutuhan suatu organisasi.'

        },

        {

            id: 'q3',

            question: 'Tertarik masuk SI? Cara daftarnya gimana?',

            answer: 'Untuk informasi pendaftaran, kamu bisa menghubungi Prodi Sistem Informasi melalui WhatsApp atau email.<br><br>📱 <strong>WhatsApp:</strong> <a href="https://wa.me/' + PRODI_DATA.whatsappClean + '" target="\_blank" style="color:#2563eb;font-weight:700;">' + PRODI_DATA.whatsapp + '</a><br>✉️ <strong>Email:</strong> ' + PRODI_DATA.email

        },

        {

            id: 'q4',

            question: 'Kalau kuliah di SI, biayanya berapa?',

            answer: 'Biaya pendaftaran mahasiswa baru sebesar <strong>Rp150.000</strong>.<br><br>Untuk pendidikan Semester 1:<br><br><strong>Paket Rp11.000.000</strong><br>• DPP: Rp5.000.000<br>• Biaya Kuliah Semester 1: Rp6.000.000<br><br>Terdapat juga biaya pendidikan <strong>Rp8.000.000 untuk D3 & S1</strong>:<br>• DPP: Rp2.000.000<br>• Biaya Kuliah Semester 1: Rp6.000.000<br><br><em>Biaya pendidikan dapat diangsur/dicicil.</em>'

        },

        {

            id: 'q5',

            question: 'Ada beasiswa yang bisa diikuti nggak?',

            answer: 'Informasi beasiswa dan jalur pendaftaran dapat berubah sesuai periode penerimaan mahasiswa baru. Untuk informasi terbaru mengenai program beasiswa, persyaratan, dan periode pendaftarannya, silakan langsung hubungi Prodi Sistem Informasi atau bagian PMB.'

        },

        {

            id: 'q6',

            question: 'Mau tanya-tanya soal SI? Hubungi siapa ya?',

            answer: 'Boleh langsung hubungi Prodi Sistem Informasi:<br><br>📱 <strong>WhatsApp:</strong> <a href="https://wa.me/' + PRODI_DATA.whatsappClean + '" target="\_blank" style="color:#2563eb;font-weight:700;">' + PRODI_DATA.whatsapp + '</a><br>✉️ <strong>Email:</strong> ' + PRODI_DATA.email

        }

    ];



    // ── STATE MANAGEMENT ──────────────────────────────────────────

    let isWindowOpen = false;

    let inactivityTimer = null;

    const INACTIVITY_LIMIT_MS = 3 * 60 * 1000; // 3 Menit (Section 22)

    let isSessionEnded = false;



    // Elements

    const toggleBtn = document.getElementById('minsiToggleBtn');

    const closeBtn = document.getElementById('minsiCloseBtn');

    const resetBtn = document.getElementById('minsiResetBtn');

    const chatWindow = document.getElementById('minsiWindow');

    const chatBody = document.getElementById('minsiChatBody');

    const timerNotice = document.getElementById('minsiTimerNotice');



    // ── TIMEOUT LOGIC (3 MENIT) ───────────────────────────────────

    function resetInactivityTimer() {

        if (isSessionEnded) return;

        clearTimeout(inactivityTimer);

        timerNotice.style.display = 'none';



        inactivityTimer = setTimeout(() => {

            triggerTimeout();

        }, INACTIVITY_LIMIT_MS);

    }



    function triggerTimeout() {

        isSessionEnded = true;

        timerNotice.style.display = 'block';



        appendBotMessage(`

            <div style="color: #dc2626; font-weight: 700; margin-bottom: 6px;">

                <i class="fa-solid fa-triangle-exclamation"></i> Sesi Berakhir

            </div>

            Sesi kamu sudah berakhir karena tidak ada aktivitas selama 3 menit.<br><br>

            Kalau masih ada yang ingin ditanyakan, kamu bisa memulai sesi baru atau langsung menghubungi Prodi Sistem Informasi.

            <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 14px;">

                <button type="button" class="minsi-action-btn" onclick="window.minsiStartNewSession()">

                    <i class="fa-solid fa-rotate-right"></i> Mulai Sesi Baru

                </button>

                <a href="https://wa.me/${PRODI_DATA.whatsappClean}" target="\_blank" class="minsi-action-btn" style="background: #10b981; text-decoration: none;">

                    <i class="fa-brands fa-whatsapp"></i> Chat WhatsApp

                </a>

            </div>

        `);

    }



    // ── UI HELPERS ────────────────────────────────────────────────

    function scrollToBottom() {

        chatBody.scrollTop = chatBody.scrollHeight;

    }



    function appendBotMessage(htmlContent) {

        const msgDiv = document.createElement('div');

        msgDiv.className = 'minsi-bubble minsi-bubble-bot';

        msgDiv.innerHTML = htmlContent;

        chatBody.appendChild(msgDiv);

        scrollToBottom();

        resetInactivityTimer();

    }



    function appendUserMessage(text) {

        const msgDiv = document.createElement('div');

        msgDiv.className = 'minsi-bubble minsi-bubble-user';

        msgDiv.textContent = text;

        chatBody.appendChild(msgDiv);

        scrollToBottom();

        resetInactivityTimer();

    }



    // ── GREETING & INITIAL FLOW (SECTION 20 & 23) ─────────────────

    function initGreeting() {

        chatBody.innerHTML = '';

        isSessionEnded = false;

        timerNotice.style.display = 'none';



        appendBotMessage(`

            <div style="margin-bottom: 8px;">

                <strong>Halo! 👋 Selamat datang di FAQ Sistem Informasi.</strong>

            </div>

            Aku <strong>MinSI</strong>, siap bantu jawab pertanyaan kamu seputar Sistem Informasi, perkuliahan, pendaftaran, biaya, konsentrasi, dan informasi lainnya.

            <br><br>

            Sebelum mulai, kamu termasuk:

            <div style="margin-top: 12px; display: flex; flex-direction: column; gap: 6px;">

                <button type="button" class="minsi-chip-btn" onclick="window.minsiSelectVisitor('MAHASISWA_AKTIF')">

                     Saya Mahasiswa Aktif

                </button>

                <button type="button" class="minsi-chip-btn" onclick="window.minsiSelectVisitor('CALON_MAHASISWA')">

                     Saya Ingin Bertanya sebagai Calon Mahasiswa

                </button>

            </div>



        `);

    }



    // ── VISITOR TYPE SELECTION (SECTION 15) ───────────────────────

    window.minsiSelectVisitor = function(type) {

        if (isSessionEnded) return;



        if (type === 'MAHASISWA_AKTIF') {

            appendUserMessage('Saya Mahasiswa Aktif');

            setTimeout(() => {

                appendBotMessage(`

                    <strong>Halo teman mahasiswa! 👋</strong><br>

                    Silakan isi identitas dan pertanyaan kamu di bawah ini agar bisa ditindaklanjuti oleh Prodi:

                    <form id="minsiMhsForm" onsubmit="window.minsiSubmitMhs(event)" style="margin-top: 12px;">

                        <input type="text" id="mhsNim" class="minsi-form-input" placeholder="NIM kamu (wajib)" required>

                        <input type="text" id="mhsName" class="minsi-form-input" placeholder="Nama lengkap kamu (wajib)" required>

                        <select id="mhsLevel" class="minsi-form-input" required>

                            <option value="">-- Pilih Tingkat Perkuliahan --</option>

                            <option value="1">Tingkat 1</option>

                            <option value="2">Tingkat 2</option>

                            <option value="3">Tingkat 3</option>

                            <option value="4">Tingkat 4</option>

                        </select>

                        <input type="text" id="mhsPhone" class="minsi-form-input" placeholder="Nomor telepon (wajib)" required>



                        </select>

                        <textarea id="mhsQuestion" class="minsi-form-input" rows="3" placeholder="Tuliskan pertanyaan kamu di sini..." required style="resize: none;"></textarea>



                        <div id="mhsError" style="display: none; color: #dc2626; font-size: 0.76rem; margin-bottom: 8px;"></div>



                        <button type="submit" id="mhsSubmitBtn" class="minsi-action-btn" style="width: 100%; justify-content: center;">

                            <i class="fa-solid fa-paper-plane"></i> Kirim Pertanyaan

                        </button>

                    </form>

                `);

            }, 300);

        } else if (type === 'CALON_MAHASISWA') {

            appendUserMessage('Saya Ingin Mendaftar');

            setTimeout(() => {

                appendBotMessage(`

                    <strong>Selamat datang calon mahasiswa baru! 🎉</strong><br>

Silakan isi nama dan nomor WhatsApp kamu agar tim Prodi SI bisa menghubungi kamu:



<form id="minsiCalonForm" onsubmit="window.minsiSubmitCalon(event)" style="margin-top: 12px;">



    <input type="text"

           id="calonName"

           class="minsi-form-input"

           placeholder="Nama lengkap kamu (wajib)"

           required>



    <input type="text"

           id="calonWa"

           class="minsi-form-input"

           placeholder="Nomor WhatsApp aktif (wajib, cth: 0812xxx)"

           required>



    <input type="text"

           id="calonSchool"

           class="minsi-form-input"

           placeholder="Asal Sekolah (wajib)"

           required>



    <select id="calonProdi" class="minsi-form-input" required>

        <option value="">-- Pilih Prodi yang diminati --</option>

        <option value="SISTEM_INFORMASI">Sistem Informasi</option>

        <option value="INFORMATIKA">Informatika</option>

        <option value="AKUNTANSI">Akuntansi</option>

        <option value="ADMINISTRASI_BISNIS">Administrasi Bisnis</option>

    </select>



    <div id="calonError"

         style="display: none; color: #dc2626; font-size: 0.76rem; margin-bottom: 8px;">

    </div>



    <button type="submit"

            id="calonSubmitBtn"

            class="minsi-action-btn"

            style="width: 100%; justify-content: center;">

        <i class="fa-solid fa-paper-plane"></i> Kirim Jawaban

    </button>



</form>

                `);

            }, 300);

        }

    };



    // ── FORM SUBMISSIONS ──────────────────────────────────────────

   window.minsiSubmitMhs = function(e) {
    e.preventDefault();

    if (isSessionEnded) return;

    const nim = document.getElementById('mhsNim').value.trim();
    const name = document.getElementById('mhsName').value.trim();
    const level = document.getElementById('mhsLevel').value;
    const question = document.getElementById('mhsQuestion').value.trim();
    const phone = document.getElementById('mhsPhone').value.trim();

    const errDiv = document.getElementById('mhsError');
    const submitBtn = document.getElementById('mhsSubmitBtn');

    if (!nim || !name || !phone || !level || !question) {
        errDiv.textContent = 'Semua data wajib diisi.';
        errDiv.style.display = 'block';
        return;
    }

    submitBtn.disabled = true;

    submitBtn.innerHTML =
        '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';

    fetch('/faq/submit', {
        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },

        body: JSON.stringify({
            visitor_type: 'MAHASISWA_AKTIF',
            nim: nim,
            name: name,
            phone: phone,
            level: level,
            question: question
        })
    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {

            appendBotMessage(`
                <div style="color: #059669; font-weight: 700; margin-bottom: 6px;">
                    <i class="fa-solid fa-circle-check"></i>
                    Pertanyaan berhasil dikirim.
                </div>

                Terima kasih <strong>${name}</strong>, pertanyaan kamu
                sudah diterima oleh Prodi Sistem Informasi dan segera ditindaklanjuti.
            `);

            setTimeout(() => {
    appendBotMessage(`
        <div style="margin-top: 10px;">
            <strong>Ada yang mau ditanyakan lagi?</strong>

            <div style="display: flex; gap: 8px; margin-top: 12px;">

                <button
                    type="button"
                    class="minsi-action-btn"
                    onclick="window.minsiFollowUp(true)"
                    style="flex: 1; justify-content: center;"
                >
                    <i class="fa-solid fa-check"></i>
                    Ya, ada pertanyaan lagi
                </button>

                <button
                    type="button"
                    class="minsi-action-btn"
                    onclick="window.minsiFollowUp(false)"
                    style="flex: 1; justify-content: center;"
                >
                    <i class="fa-solid fa-xmark"></i>
                    Tidak, sudah cukup
                </button>

            </div>
        </div>
    `);
}, 500);

        } else {

            errDiv.textContent =
                data.message || 'Terjadi kesalahan. Coba lagi.';

            errDiv.style.display = 'block';

            submitBtn.disabled = false;

            submitBtn.innerHTML =
                '<i class="fa-solid fa-paper-plane"></i> Kirim Pertanyaan';
        }

    })
    .catch(err => {

        console.error(err);

        errDiv.textContent =
            'Gagal terhubung ke server. Silakan hubungi via WhatsApp.';

        errDiv.style.display = 'block';

        submitBtn.disabled = false;

        submitBtn.innerHTML =
            '<i class="fa-solid fa-paper-plane"></i> Kirim Pertanyaan';
    });
};



    window.minsiSubmitCalon = function(e) {

        e.preventDefault();

        if (isSessionEnded) return;



        const name = document.getElementById('calonName').value.trim();

        const wa = document.getElementById('calonWa').value.trim();

        const school = document.getElementById('calonSchool').value.trim();

        const prodi = document.getElementById('calonProdi').value;

        const errDiv = document.getElementById('calonError');

        const submitBtn = document.getElementById('calonSubmitBtn');



        if (!name || !wa || !school || !prodi) {

            errDiv.textContent = 'Semua data wajib diisi.';

            errDiv.style.display = 'block';

            return;

        }



        submitBtn.disabled = true;

        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';



        fetch('/faq/submit', {

            method: 'POST',

            headers: {

                'Content-Type': 'application/json',

                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''

            },

            body: JSON.stringify({

                visitor_type: 'CALON_MAHASISWA',

                name: name,

                whatsapp: wa,

                school_origin: school,

                desired_prodi: prodi,

                question: 'Data pendaftaran calon mahasiswa'

            })

        })

        .then(res => res.json())

        .then(data => {

            if (data.success) {

                appendBotMessage(`

                    <div style="color: #059669; font-weight: 700; margin-bottom: 6px;">

                        <i class="fa-solid fa-circle-check"></i> Data berhasil dikirim.

                    </div>

                    Terima kasih <strong>${name}</strong>, data kamu sudah diterima oleh Prodi Sistem Informasi.

                `);

                showFaqMenu();

            } else {

                errDiv.textContent = data.message || 'Terjadi kesalahan. Coba lagi.';

                errDiv.style.display = 'block';

                submitBtn.disabled = false;

                submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Kirim Jawaban';

            }

        })

        .catch(err => {

            errDiv.textContent = 'Gagal terhubung ke server. Silakan hubungi via WhatsApp.';

            errDiv.style.display = 'block';

            submitBtn.disabled = false;

            submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Kirim Jawaban';

        });

    };



    // ── SHOW INSTANT FAQ ANSWER ───────────────────────────────────

    window.minsiShowFaq = function(id) {

        if (isSessionEnded) return;



        const item = FAQ_LIST.find(f => f.id === id);

        if (!item) return;



        appendUserMessage(item.question);



        setTimeout(() => {

            appendBotMessage(item.answer);

            askFollowUp();

        }, 350);

    };



    // ── FAQ MENU AFTER CALON MAHASISWA REGISTRATION ───────────────

    function showFaqMenu() {

        setTimeout(() => {

            appendBotMessage(`

                <strong>Silakan pilih topik yang ingin kamu tanyakan:</strong>

                <div style="margin-top: 10px;">

                    ${FAQ_LIST.map((faq) => `

                        <button type="button" class="minsi-chip-btn" onclick="window.minsiShowFaq('${faq.id}')">

                            💬 ${faq.question}

                        </button>

                    `).join('')}

                </div>

            `);

        }, 500);

    }


    // ── FOLLOW-UP QUESTION (SECTION 21) ───────────────────────────

    function askFollowUp() {

        setTimeout(() => {

            appendBotMessage(`

                <strong>Ada yang mau ditanyakan lagi?</strong>

                <div style="margin-top: 10px; display: flex; gap: 8px;">

                    <button type="button" class="minsi-action-btn" onclick="window.minsiFollowUp('YES')">

                        <i class="fa-solid fa-check"></i> Ya, ada pertanyaan lagi

                    </button>

                    <button type="button" class="minsi-action-btn" style="background: #64748b;" onclick="window.minsiFollowUp('NO')">

                        <i class="fa-solid fa-xmark"></i> Tidak, sudah cukup

                    </button>

                </div>

            `);

        }, 500);

    }



    window.minsiFollowUp = function(choice) {

        if (isSessionEnded) return;



        if (choice === 'YES') {

            appendUserMessage('Ya, ada pertanyaan lagi');

            setTimeout(() => {

                appendBotMessage(`

                    Silakan pilih topik pertanyaan lain atau kamu juga bisa mengajukan pertanyaan khusus ke admin prodi:

                    <div style="margin-top: 10px; display: flex; flex-direction: column; gap: 6px;">

                        <button type="button" class="minsi-chip-btn" onclick="window.minsiSelectVisitor('MAHASISWA_AKTIF')">

                            🎓 Ajukan Pertanyaan Mahasiswa Aktif

                        </button>

                        <button type="button" class="minsi-chip-btn" onclick="window.minsiSelectVisitor('CALON_MAHASISWA')">

                            📝 Ajukan Pertanyaan Calon Mahasiswa

                        </button>

                    </div>

                    <div style="margin-top: 10px; font-size: 0.76rem; color: #64748b;">Topik pertanyaan umum:</div>

                    <div style="margin-top: 6px;">

                        ${FAQ_LIST.map((faq) => `

                            <button type="button" class="minsi-chip-btn" onclick="window.minsiShowFaq('${faq.id}')">

                                💬 ${faq.question}

                            </button>

                        `).join('')}

                    </div>

                `);

            }, 300);

        } else {

            appendUserMessage('Tidak, sudah cukup');

            setTimeout(() => {

                appendBotMessage(`

                    <strong>Oke, terima kasih sudah menghubungi MinSI! 👋</strong><br><br>

                    Kalau nanti masih ada yang ingin ditanyakan, kamu bisa kembali ke FAQ atau langsung hubungi Prodi Sistem Informasi.

                    <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 14px;">

                        <button type="button" class="minsi-action-btn" onclick="window.minsiStartNewSession()">

                            <i class="fa-solid fa-rotate-left"></i> Kembali ke FAQ

                        </button>

                        <a href="https://wa.me/${PRODI_DATA.whatsappClean}?text=Halo%20Prodi%20Sistem%20Informasi%20LPKIA,%20saya%20ingin%20bertanya" target="\_blank" class="minsi-action-btn" style="background: #10b981; text-decoration: none; justify-content: center;">

                            <i class="fa-brands fa-whatsapp"></i> Chat WhatsApp Prodi SI

                        </a>

                    </div>

                `);

            }, 300);

        }

    };



    window.minsiStartNewSession = function() {

        initGreeting();

    };



    // ── OPEN / CLOSE / RESET HANDLERS ─────────────────────────────

    toggleBtn.addEventListener('click', () => {

        isWindowOpen = !isWindowOpen;

        if (isWindowOpen) {

            chatWindow.style.display = 'flex';

            if (chatBody.children.length === 0) {

                initGreeting();

            } else {

                resetInactivityTimer();

            }

        } else {

            chatWindow.style.display = 'none';

        }

    });



    closeBtn.addEventListener('click', () => {

        isWindowOpen = false;

        chatWindow.style.display = 'none';

    });



    resetBtn.addEventListener('click', () => {

        if (confirm('Mulai ulang percakapan dengan MinSI?')) {

            initGreeting();

        }

    });



    // Detect user interactions to reset timer

    chatBody.addEventListener('click', resetInactivityTimer);

    chatBody.addEventListener('keydown', resetInactivityTimer);



})();

</script>
