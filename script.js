// Управление вводом и отправкой данных

let currentExpression = '';

// Получение элементов
const display = document.getElementById('display');
const form = document.getElementById('calculatorForm');

// Функция обновления дисплея
function updateDisplay(value) {
    display.value = value;
    // Прокрутка к концу, если текст длинный
    display.scrollLeft = display.scrollWidth;
}

// Функция добавления символа
function addToExpression(value) {
    currentExpression = display.value;
    
    // Обработка специальных функций
    if (value === '√(') {
        currentExpression += '√(';
    } else if (value === 'ln(') {
        currentExpression += 'ln(';
    } else if (value === 'log(') {
        currentExpression += 'log(';
    } else if (value === '(-)') {
        // Добавляем унарный минус
        currentExpression += '(-';
        // Автоматически добавляем закрывающую скобку
        setTimeout(() => {
            currentExpression = display.value;
            if (!currentExpression.endsWith(')')) {
                addToExpression(')');
            }
        }, 10);
        return;
    } else {
        currentExpression += value;
    }
    
    updateDisplay(currentExpression);
}

// Функция очистки
function clearDisplay() {
    updateDisplay('');
    document.getElementById('resultValue').innerText = '';
}

// Функция отправки формы
function calculate() {
    const expression = display.value;
    
    if (!expression.trim()) {
        document.getElementById('resultValue').innerText = 'Введите выражение';
        return;
    }
    
    // Отправляем через POST
    const formData = new FormData(form);
    formData.set('expression', expression);
    
    fetch('index.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(html => {
        // Извлекаем результат из полученного HTML
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newResult = doc.getElementById('resultValue')?.innerText;
        const newDisplay = doc.querySelector('#display')?.value;
        
        if (newResult !== undefined) {
            document.getElementById('resultValue').innerText = newResult;
        }
        if (newDisplay !== undefined) {
            updateDisplay(newDisplay);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('resultValue').innerText = 'Ошибка соединения';
    });
}

// Обработка кнопок
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        
        if (button.classList.contains('clear')) {
            clearDisplay();
        } else if (button.classList.contains('equals')) {
            calculate();
        } else {
            const value = button.getAttribute('data-value');
            if (value) {
                addToExpression(value);
            }
        }
    });
});

// Поддержка ввода с клавиатуры
document.addEventListener('keydown', (e) => {
    const key = e.key;
    
    // Цифры и десятичная точка
    if (/^[0-9]$/.test(key)) {
        e.preventDefault();
        addToExpression(key);
    }
    // Десятичная точка
    else if (key === '.') {
        e.preventDefault();
        addToExpression('.');
    }
    // Операторы
    else if (key === '+') {
        e.preventDefault();
        addToExpression('+');
    }
    else if (key === '-') {
        e.preventDefault();
        addToExpression('-');
    }
    else if (key === '*') {
        e.preventDefault();
        addToExpression('*');
    }
    else if (key === '/') {
        e.preventDefault();
        addToExpression('/');
    }
    // Степень
    else if (key === '^') {
        e.preventDefault();
        addToExpression('^');
    }
    // Факториал
    else if (key === '!') {
        e.preventDefault();
        addToExpression('!');
    }
    // Скобки
    else if (key === '(') {
        e.preventDefault();
        addToExpression('(');
    }
    else if (key === ')') {
        e.preventDefault();
        addToExpression(')');
    }
    // Константы
    else if (key === 'p' || key === 'P') {
        e.preventDefault();
        addToExpression('π');
    }
    else if (key === 'e') {
        e.preventDefault();
        addToExpression('e');
    }
    // Функции
    else if (key === 'r' || key === 'R') {
        e.preventDefault();
        addToExpression('√(');
    }
    else if (key === 'l') {
        e.preventDefault();
        // Поддержка ln и log через последовательный ввод
        setTimeout(() => {
            currentExpression = display.value;
            if (currentExpression.endsWith('l')) {
                updateDisplay(currentExpression.slice(0, -1) + 'ln(');
            }
        }, 10);
        addToExpression('l');
    }
    // Enter для вычисления
    else if (key === 'Enter') {
        e.preventDefault();
        calculate();
    }
    // Escape для очистки
    else if (key === 'Escape') {
        e.preventDefault();
        clearDisplay();
    }
    // Backspace для удаления последнего символа
    else if (key === 'Backspace') {
        e.preventDefault();
        currentExpression = display.value.slice(0, -1);
        updateDisplay(currentExpression);
    }
});

// Фокус на поле ввода для удобства
display.addEventListener('click', () => {
    // Можно добавить курсор в конец
    display.scrollLeft = display.scrollWidth;
});

// Валидация перед отправкой
form.addEventListener('submit', (e) => {
    e.preventDefault();
    calculate();
});