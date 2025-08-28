@extends('layouts.admin')

@section('content')

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f4f4;
        margin: 0;
        padding: 20px;
    }
    .container {
        max-width: 1000px;
        margin: auto;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h1 {
        color: #00695C;
        margin-bottom: 25px;
        font-weight: 600;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .form-container {
        background: #f9f9f9;
        padding: 25px;
        border-radius: 8px;
        margin-bottom: 30px;
        border: 1px solid #e0e0e0;
    }
    .close-form {
        background: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
        text-decoration: none;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 15px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #555;
    }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        font-size: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: border-color 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: #00695C;
        box-shadow: 0 0 0 2px rgba(0,105,92,0.1);
    }
    textarea.form-control {
        min-height: 80px;
        resize: vertical;
    }
    .file-upload {
        grid-column: span 2;
        margin-top: 10px;
    }
    .file-upload-label {
        display: block;
        margin-bottom: 5px;
    }
    .image-preview {
        margin-top: 10px;
        max-width: 200px;
        max-height: 150px;
        border-radius: 4px;
        display: none;
    }
    .submit-btn {
        background: #00695C;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
        grid-column: span 2;
        margin-top: 10px;
    }
    .submit-btn:hover {
        background: #004D40;
    }
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 1em;
    }
    .editor-container {
        grid-column: span 2;
        margin-bottom: 15px;
    }
    .editor-toolbar {
        border: 1px solid #ddd;
        border-bottom: none;
        border-radius: 4px 4px 0 0;
        padding: 8px;
        background: #f8f9fa;
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
    }
    .editor-toolbar button {
        background: white;
        border: 1px solid #ddd;
        border-radius: 3px;
        padding: 5px 8px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
        height: 30px;
    }
    .editor-toolbar button:hover {
        background: #f0f0f0;
    }
    .editor-toolbar select {
        padding: 4px;
        border: 1px solid #ddd;
        border-radius: 3px;
        background: white;
    }
    .editor-content {
        min-height: 200px;
        border: 1px solid #ddd;
        border-radius: 0 0 4px 4px;
        padding: 12px;
        font-family: inherit;
        overflow-y: auto;
    }
    .editor-content:focus {
        outline: none;
        border-color: #00695C;
        box-shadow: 0 0 0 2px rgba(0,105,92,0.1);
    }
    .editor-content ol {
        margin: 0;
        padding-left: 20px;
    }
    .editor-content li {
        margin-bottom: 5px;
    }
    .color-picker {
        position: relative;
        display: inline-block;
    }
    .color-options {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 8px;
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 4px;
        z-index: 10;
        display: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .color-option {
        width: 20px;
        height: 20px;
        border-radius: 3px;
        cursor: pointer;
        border: 1px solid #eee;
    }
    .color-option:hover {
        transform: scale(1.1);
    }
    .show-color-options {
        display: grid !important;
    }
    .alert {
        padding: 12px 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        display: none;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
</style>

<div class="container">
    <h1>
        {{ isset($course) ? 'Edit Course' : 'Add New Course' }}
        <a href="{{ route('admin.course') }}" class="close-form">Cancel</a>
    </h1>

    <div class="form-container">
        <form id="courseForm" 
              action="{{ isset($course) ? route('courses.update', $course->id) : route('courses.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @if(isset($course))
                @method('PUT')
                <input type="hidden" id="courseId" value="{{ $course->id }}">
            @endif
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="title">Course Title</label>
                    <input type="text" id="title" name="title" class="form-control" 
                           placeholder="Enter course title" value="{{ old('title', $course->title ?? '') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="instructor">Instructor</label>
                    <input type="text" id="instructor" name="instructor" class="form-control" 
                           placeholder="Enter instructor name" value="{{ old('instructor', $course->instructor ?? '') }}" required>
                </div>
                
                <div class="editor-container">
                    <label for="description">Course Description</label>
                    <div class="editor-toolbar" id="descriptionToolbar">
                        <select onchange="formatText('description', 'formatBlock', this.value)">
                            <option value="p">Paragraph</option>
                            <option value="h1">Heading 1</option>
                            <option value="h2">Heading 2</option>
                            <option value="h3">Heading 3</option>
                            <option value="h4">Heading 4</option>
                            <option value="blockquote">Quote</option>
                        </select>
                        <select onchange="formatText('description', 'fontName', this.value)">
                            <option value="Arial">Arial</option>
                            <option value="Helvetica">Helvetica</option>
                            <option value="Times New Roman">Times New Roman</option>
                            <option value="Courier New">Courier New</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Verdana">Verdana</option>
                        </select>
                        <select onchange="formatText('description', 'fontSize', this.value)">
                            <option value="1">Small</option>
                            <option value="2">Normal</option>
                            <option value="3">Large</option>
                            <option value="4">X-Large</option>
                            <option value="5">XX-Large</option>
                        </select>
                        <button type="button" onclick="formatText('description', 'bold')" title="Bold"><strong>B</strong></button>
                        <button type="button" onclick="formatText('description', 'italic')" title="Italic"><em>I</em></button>
                        <button type="button" onclick="formatText('description', 'underline')" title="Underline"><u>U</u></button>
                        <button type="button" onclick="formatText('description', 'strikeThrough')" title="Strikethrough"><s>S</s></button>
                        <button type="button" onclick="formatText('description', 'justifyLeft')" title="Align Left">↖</button>
                        <button type="button" onclick="formatText('description', 'justifyCenter')" title="Align Center">↔</button>
                        <button type="button" onclick="formatText('description', 'justifyRight')" title="Align Right">↗</button>
                        <button type="button" onclick="formatText('description', 'justifyFull')" title="Justify">≡</button>
                        <button type="button" onclick="formatText('description', 'insertUnorderedList')" title="Bullet List">•</button>
                        <button type="button" onclick="formatText('description', 'insertOrderedList')" title="Numbered List">1.</button>
                        <button type="button" onclick="formatText('description', 'outdent')" title="Outdent">←</button>
                        <button type="button" onclick="formatText('description', 'indent')" title="Indent">→</button>
                        <div class="color-picker">
                            <button type="button" onclick="toggleColorOptions('foreColorOptions')" title="Text Color">A</button>
                            <div id="foreColorOptions" class="color-options">
                                <div class="color-option" style="background-color: #000000;" onclick="setColor('description', 'foreColor', '#000000')"></div>
                                <div class="color-option" style="background-color: #FF0000;" onclick="setColor('description', 'foreColor', '#FF0000')"></div>
                                <div class="color-option" style="background-color: #00FF00;" onclick="setColor('description', 'foreColor', '#00FF00')"></div>
                                <div class="color-option" style="background-color: #0000FF;" onclick="setColor('description', 'foreColor', '#0000FF')"></div>
                                <div class="color-option" style="background-color: #FFFF00;" onclick="setColor('description', 'foreColor', '#FFFF00')"></div>
                                <div class="color-option" style="background-color: #FF00FF;" onclick="setColor('description', 'foreColor', '#FF00FF')"></div>
                                <div class="color-option" style="background-color: #00FFFF;" onclick="setColor('description', 'foreColor', '#00FFFF')"></div>
                                <div class="color-option" style="background-color: #FFFFFF; border: 1px solid #ccc;" onclick="setColor('description', 'foreColor', '#FFFFFF')"></div>
                            </div>
                        </div>
                        <div class="color-picker">
                            <button type="button" onclick="toggleColorOptions('backColorOptions')" title="Background Color">BG</button>
                            <div id="backColorOptions" class="color-options">
                                <div class="color-option" style="background-color: #FFCCCB;" onclick="setColor('description', 'backColor', '#FFCCCB')"></div>
                                <div class="color-option" style="background-color: #ADD8E6;" onclick="setColor('description', 'backColor', '#ADD8E6')"></div>
                                <div class="color-option" style="background-color: #90EE90;" onclick="setColor('description', 'backColor', '#90EE90')"></div>
                                <div class="color-option" style="background-color: #FFFFE0;" onclick="setColor('description', 'backColor', '#FFFFE0')"></div>
                                <div class="color-option" style="background-color: #E6E6FA;" onclick="setColor('description', 'backColor', '#E6E6FA')"></div>
                                <div class="color-option" style="background-color: #FFD700;" onclick="setColor('description', 'backColor', '#FFD700')"></div>
                                <div class="color-option" style="background-color: #FFB6C1;" onclick="setColor('description', 'backColor', '#FFB6C1')"></div>
                                <div class="color-option" style="background-color: #FFFFFF; border: 1px solid #ccc;" onclick="setColor('description', 'backColor', '#FFFFFF')"></div>
                            </div>
                        </div>
                        <button type="button" onclick="formatText('description', 'removeFormat')" title="Remove Formatting">Clear</button>
                        <button type="button" onclick="formatText('description', 'undo')" title="Undo">↶</button>
                        <button type="button" onclick="formatText('description', 'redo')" title="Redo">↷</button>
                    </div>
                    <div 
                        id="description" 
                        class="editor-content" 
                        contenteditable="true"
                        oninput="debouncedUpdateHiddenInput('description', 'hiddenDescription')"
                    >{!! old('description', $course->description ?? '') !!}</div>
                    <input type="hidden" id="hiddenDescription" name="description" value="{{ old('description', $course->description ?? '') }}">
                </div>
                
                <div class="editor-container">
                    <label for="topics">Course Topics (enter one per line or comma-separated, displayed as numbered list)</label>
                    <div class="editor-toolbar" id="topicsToolbar">
                        <button type="button" onclick="formatText('topics', 'bold')" title="Bold"><strong>B</strong></button>
                        <button type="button" onclick="formatText('topics', 'italic')" title="Italic"><em>I</em></button>
                        <button type="button" onclick="formatText('topics', 'underline')" title="Underline"><u>U</u></button>
                        <button type="button" onclick="formatText('topics', 'insertUnorderedList')" title="Bullet List">•</button>
                        <button type="button" onclick="formatText('topics', 'insertOrderedList')" title="Numbered List">1.</button>
                        <button type="button" onclick="addNumberedTopic()" title="Add Numbered Topic">+1</button>
                        <div class="color-picker">
                            <button type="button" onclick="toggleColorOptions('topicsForeColorOptions')" title="Text Color">A</button>
                            <div id="topicsForeColorOptions" class="color-options">
                                <div class="color-option" style="background-color: #000000;" onclick="setColor('topics', 'foreColor', '#000000')"></div>
                                <div class="color-option" style="background-color: #FF0000;" onclick="setColor('topics', 'foreColor', '#FF0000')"></div>
                                <div class="color-option" style="background-color: #00FF00;" onclick="setColor('topics', 'foreColor', '#00FF00')"></div>
                                <div class="color-option" style="background-color: #0000FF;" onclick="setColor('topics', 'foreColor', '#0000FF')"></div>
                                <div class="color-option" style="background-color: #FFFF00;" onclick="setColor('topics', 'foreColor', '#FFFF00')"></div>
                                <div class="color-option" style="background-color: #FF00FF;" onclick="setColor('topics', 'foreColor', '#FF00FF')"></div>
                                <div class="color-option" style="background-color: #00FFFF;" onclick="setColor('topics', 'foreColor', '#00FFFF')"></div>
                                <div class="color-option" style="background-color: #FFFFFF; border: 1px solid #ccc;" onclick="setColor('topics', 'foreColor', '#FFFFFF')"></div>
                            </div>
                        </div>
                    </div>
                    <div 
                        id="topics" 
                        class="editor-content" 
                        contenteditable="true"
                        oninput="debouncedUpdateHiddenInput('topics', 'hiddenTopics')"
                    >{!! old('topics', $course->topics ?? '') !!}</div>
                    <input type="hidden" id="hiddenTopics" name="topics" value="{{ old('topics', $course->topics ?? '') }}">
                </div>
                
                <div class="form-group">
                    <label for="views">Views</label>
                    <input type="number" id="views" name="views" class="form-control" 
                           placeholder="e.g. 3800" value="{{ old('views', $course->views ?? '') }}">
                </div>
                
                <div class="form-group">
                    <label for="time">Time (minutes)</label>
                    <input type="number" id="time" name="time" class="form-control" 
                           placeholder="e.g. 120" value="{{ old('time', $course->time ?? '') }}">
                </div>
                
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="">Select Category</option>
                        <option value="Frontend" {{ (old('category', $course->category ?? '') == 'Frontend') ? 'selected' : '' }}>Frontend</option>
                        <option value="Backend" {{ (old('category', $course->category ?? '') == 'Backend') ? 'selected' : '' }}>Backend</option>
                        <option value="Full Stack" {{ (old('category', $course->category ?? '') == 'Full Stack') ? 'selected' : '' }}>Full Stack</option>
                        <option value="Framework" {{ (old('category', $course->category ?? '') == 'Framework') ? 'selected' : '' }}>Framework</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="level">Level</label>
                    <select id="level" name="level" class="form-control" required>
                        <option value="">Select Level</option>
                        <option value="Beginner" {{ (old('level', $course->level ?? '') == 'Beginner') ? 'selected' : '' }}>Beginner</option>
                        <option value="Intermediate" {{ (old('level', $course->level ?? '') == 'Intermediate') ? 'selected' : '' }}>Intermediate</option>
                        <option value="Advanced" {{ (old('level', $course->level ?? '') == 'Advanced') ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="duration">Duration (minutes)</label>
                    <input type="number" id="duration" name="duration" class="form-control" 
                           placeholder="e.g. 480" value="{{ old('duration', $course->duration ?? '') }}">
                </div>
                
                <div class="form-group">
                    <label for="lessons">Lessons</label>
                    <input type="number" id="lessons" name="lessons" class="form-control" 
                           placeholder="e.g. 32" value="{{ old('lessons', $course->lessons ?? '') }}">
                </div>
                
                <div class="form-group">
                    <label for="price">Price (in cents)</label>
                    <input type="number" id="price" name="price" class="form-control" 
                           placeholder="e.g. 2499 for $24.99" value="{{ old('price', $course->price ?? '') }}">
                </div>
                
                <div class="form-group file-upload">
                    <label for="thumbnail" class="file-upload-label">Course Thumbnail</label>
                    <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
                    @if(isset($course) && $course->thumbnail)
                        <img id="thumbnailPreview" class="image-preview" src="{{ $course->thumbnail }}" style="display: block;">
                    @else
                        <img id="thumbnailPreview" class="image-preview" style="display: none;">
                    @endif
                </div>
            </div>
            
            <button type="submit" class="submit-btn" id="submitBtn">
                {{ isset($course) ? 'Update Course' : 'Save Course' }}
            </button>
        </form>
    </div>
</div>

<script>
    // Log course data if in edit mode
    @if(isset($course))
        console.log('Course data loaded:');
        console.log(@json($course));
    @endif

    // Save cursor position before updating content
    function saveCursorPosition(editorId) {
        const editor = document.getElementById(editorId);
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
            const range = selection.getRangeAt(0);
            const preCaretRange = range.cloneRange();
            preCaretRange.selectNodeContents(editor);
            preCaretRange.setEnd(range.endContainer, range.endOffset);
            const cursorPosition = preCaretRange.toString().length;
            
            return {
                cursorPosition: cursorPosition,
                range: range
            };
        }
        return null;
    }

    // Restore cursor position after updating content
    function restoreCursorPosition(editorId, savedPosition) {
        if (!savedPosition) return;
        
        const editor = document.getElementById(editorId);
        const textNodes = getTextNodes(editor);
        let charCount = 0;
        let foundNode = null;
        let foundOffset = 0;
        
        for (const node of textNodes) {
            const nodeLength = node.textContent.length;
            if (savedPosition.cursorPosition <= charCount + nodeLength) {
                foundNode = node;
                foundOffset = savedPosition.cursorPosition - charCount;
                break;
            }
            charCount += nodeLength;
        }
        
        if (foundNode) {
            const selection = window.getSelection();
            const range = document.createRange();
            range.setStart(foundNode, foundOffset);
            range.collapse(true);
            selection.removeAllRanges();
            selection.addRange(range);
            editor.focus();
        }
    }

    // Get all text nodes within an element
    function getTextNodes(element) {
        const textNodes = [];
        const walker = document.createTreeWalker(
            element, 
            NodeFilter.SHOW_TEXT, 
            null, 
            false
        );
        
        let node;
        while (node = walker.nextNode()) {
            textNodes.push(node);
        }
        
        return textNodes;
    }

    // Debounced function to update hidden input
    function debouncedUpdateHiddenInput(editorId, hiddenInputId) {
        // Clear any existing timeout
        if (window[`${editorId}Timeout`]) {
            clearTimeout(window[`${editorId}Timeout`]);
        }
        
        // Save cursor position before updating
        const cursorPosition = saveCursorPosition(editorId);
        
        // Set a new timeout to update after a short delay
        window[`${editorId}Timeout`] = setTimeout(() => {
            updateHiddenInput(editorId, hiddenInputId);
            
            // Restore cursor position after update
            if (cursorPosition) {
                restoreCursorPosition(editorId, cursorPosition);
            }
        }, 300); // 300ms delay
    }

    // Text formatting functions
    function formatText(editorId, command, value = null) {
        const editor = document.getElementById(editorId);
        editor.focus();
        document.execCommand(command, false, value);
        
        // Update the hidden input after formatting
        updateHiddenInput(editorId, editorId === 'topics' ? 'hiddenTopics' : 'hiddenDescription');
    }
    
    // Add a new numbered topic
    function addNumberedTopic() {
        const editor = document.getElementById('topics');
        editor.focus();
        
        const selection = window.getSelection();
        const range = selection.getRangeAt(0);
        const parent = range.commonAncestorContainer;
        const isInOrderedList = parent.closest && (parent.closest('ol') || parent.nodeName === 'OL');
        
        if (!isInOrderedList) {
            document.execCommand('insertOrderedList', false, null);
        }
        
        document.execCommand('insertHTML', false, '<li>New Topic</li>');
        updateHiddenInput('topics', 'hiddenTopics');
    }
    
    // Set color for text or background
    function setColor(editorId, command, color) {
        const editor = document.getElementById(editorId);
        editor.focus();
        document.execCommand(command, false, color);
        hideAllColorOptions();
        
        // Update the hidden input after color change
        updateHiddenInput(editorId, editorId === 'topics' ? 'hiddenTopics' : 'hiddenDescription');
    }
    
    // Toggle color options visibility
    function toggleColorOptions(optionsId) {
        hideAllColorOptions();
        const options = document.getElementById(optionsId);
        options.classList.toggle('show-color-options');
    }
    
    // Hide all color options
    function hideAllColorOptions() {
        const allOptions = document.querySelectorAll('.color-options');
        allOptions.forEach(option => {
            option.classList.remove('show-color-options');
        });
    }
    
    // Update hidden input with editor content
    function updateHiddenInput(editorId, hiddenInputId) {
        const editor = document.getElementById(editorId);
        const hiddenInput = document.getElementById(hiddenInputId);
        hiddenInput.value = editor.innerHTML;
    }
    
    // Close color options when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.color-picker')) {
            hideAllColorOptions();
        }
    });
    
    // Thumbnail preview
    document.getElementById('thumbnail').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('thumbnailPreview').src = e.target.result;
                document.getElementById('thumbnailPreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Form submission handler
    document.getElementById('courseForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Update hidden inputs before submission
        updateHiddenInput('description', 'hiddenDescription');
        updateHiddenInput('topics', 'hiddenTopics');

        const formData = new FormData(this);
        const url = this.action;
        let method = this.querySelector('input[name="_method"]') 
                    ? this.querySelector('input[name="_method"]').value 
                    : 'POST';

        console.log('Submitting form to:', url);
        console.log('Method:', method);

        fetch(url, {
            method: method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || `HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Success:', data);
            window.location.href = '{{ route('admin.course') }}';
        })
        .catch(error => {
            console.error('Error:', error);
            alert(`An error occurred while ${document.getElementById('courseId')?.value ? 'updating' : 'saving'} the course: ${error.message}`);
        });
    });
</script>

@endsection