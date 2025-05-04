class BottomSheet {
    constructor() {
        this.instances = {};
    }

    make(options) {
        const id = options.id || 'bottomSheet';
        options.id = id;
  
        if ($(`#bs-${id}`).length > 0) {
           return;
        } 
	
        const overlay = $('<div>', {
            id:  `bs-overlay-${id}`,
            class: "fixed inset-0 bg-black/80 flex items-end justify-center z-50"
        });

        const sheet = $('<div>', {
            id: `bs-${id}`,
            class: `bottom-sheet w-full max-h-screen ${options.className?.body || ''}`
        });

        if (options.size != null) {
            if (options.size === 100) {
                sheet.css('height', '100vh').addClass('h-screen');
            } else {
                sheet.css('height', `${options.size}vh`);
            }
        }
 
        const contentWrapper = $('<div>', {
            class: `relative z-1 w-full h-max ${options.className?.sheet || ''}`
        });
 
        if (options.title?.content) {
            const titleEl = $('<div>', {
                html: options.title.content,
                class: `w-full text-2xl m-auto text-center ${options.title?.className || ''}`,
            });
            contentWrapper.append(titleEl);
        }

        if (options.message?.content) {
            const messageEl = $('<div>', { 
                class: `max-h-48 ${options.message?.className || ''}`,
                html: options.message.content
            });
            contentWrapper.append(messageEl);
        }
       
 
        this.instances[id] = {
            options,
            sheet,
            overlay
        };

        sheet.append(contentWrapper);
        overlay.append(sheet);
        $('body').append(overlay);

        if (!options.preventClose) {
            overlay.on('click', (e) => {
                if (e.target === overlay[0]) {
                    this.close(id);
                }
            });
        }

        if (options.draggable) {
            this.enableDrag(sheet[0], options);
        }

        $('html').addClass('!overflow-hidden');

        sheet.css({
            willChange: 'transform',
            transform: 'translateY(100%)',
            transition: 'none'
        });
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                sheet.css({
                    willChange: 'transform',
                    transition: 'transform 300ms cubic-bezier(0.25, 1.25, 0.5, 1)',
                    transform: 'translateY(0)'
                });
            });
        });

        if (typeof options.onOpen === 'function') {
            options.onOpen();
        }
 
    }

    enableDrag(sheetEl, options) {
        const instance = this; // ← ارجاع به کلاس
        let startY = 0,
            currentY = 0,
            dragging = false;
        let visibleHeight = 0,
            threshold = 0;

        const calcThreshold = () => {
            visibleHeight = window.innerHeight;
            const sheetHeight = sheetEl.getBoundingClientRect().height;
            threshold = sheetHeight * 0.50;
        };

        const onDragStart = (e) => {
            calcThreshold();
            dragging = true;
            startY = e.type.startsWith('touch') ?
                e.touches[0].clientY :
                e.clientY;
            sheetEl.style.transition = 'none';
            document.addEventListener('pointermove', onDragMove);
            document.addEventListener('touchmove', onDragMove, {
                passive: false
            });
            document.addEventListener('pointerup', onDragEnd);
            document.addEventListener('touchend', onDragEnd);
        };

        const onDragMove = (e) => {
            if (!dragging) return;
            const clientY = e.type.startsWith('touch') ?
                e.touches[0].clientY :
                e.clientY;
            let diffY = clientY - startY;
            if (diffY <= 0) {
                currentY = 0;
                return;
            }
            visibleHeight = window.innerHeight;
            diffY = Math.min(diffY, visibleHeight);
            sheetEl.style.transform = `translateY(${diffY}px)`;
            currentY = diffY;
            e.preventDefault();
        };

        const onDragEnd = () => {
            dragging = false;
            document.removeEventListener('pointermove', onDragMove);
            document.removeEventListener('touchmove', onDragMove);
            document.removeEventListener('pointerup', onDragEnd);
            document.removeEventListener('touchend', onDragEnd);

            // ← این شرط قبلاً inline پاک‌سازی می‌کرد؛ الان به close ارجاع می‌دهیم
            if (currentY > threshold && options.preventClose == null) {
                instance.close(options.id);
            } else {
                // bounce back
                sheetEl.style.transition = 'transform 300ms cubic-bezier(0.25, 1.3, 0.5, 1)';
                sheetEl.style.transform = 'translateY(0)';
            }
        };

        sheetEl.addEventListener('pointerdown', onDragStart);
        sheetEl.addEventListener('touchstart', onDragStart, {
            passive: true
        });
    }

    close(id) {
        const inst = this.instances[id];
        if (!inst) return;

        const {
            options,
            sheet,
            overlay
        } = inst;

        // انیمیشن پایین رفتن
        sheet.css({
            willChange: 'transform',
            transform: "translateY(100%)",
            transition: "transform 300ms ease-out"
        });

        // بعد از 300ms پوشه را حذف کن، ولی فقط اگر این inst هنوز برقرار باشد
        setTimeout(() => {
            overlay.remove();
            if (typeof options.onClose === 'function') {
                options.onClose();
            }
            if ($('.bottom-sheet').length === 0) {
                $('html').removeClass('!overflow-hidden');
            }
            // این شرط، از پاک شدن inst جدید جلوگیری می‌کند
            if (this.instances[id] === inst) {
                delete this.instances[id];
            }
        }, 300);
    }

}