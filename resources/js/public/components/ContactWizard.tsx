import { ChangeEvent, FormEvent, useEffect, useRef, useState } from 'react';
import type { ContactFixture, PublicPagePayload } from '../types';

type Step = 'input' | 'confirm' | 'complete';
type FormValues = { customerType: string; category: string; name: string; company: string; email: string; phone: string; message: string; privacy: boolean };
type FormErrors = Partial<Record<keyof FormValues | 'attachments', string>>;
type Attachment = { file: File; preview: string };

const initialValues: FormValues = { customerType: '', category: '', name: '', company: '', email: '', phone: '', message: '', privacy: false };

function format(template: string, values: Record<string, string | number>) {
    return Object.entries(values).reduce((result, [key, value]) => result.replaceAll(`{${key}}`, String(value)), template);
}

function StepIndicator({ step, contact }: { step: Step; contact: ContactFixture }) {
    const steps: Array<{ id: Step; label: string }> = [
        { id: 'input', label: contact.ui.steps.input }, { id: 'confirm', label: contact.ui.steps.confirm }, { id: 'complete', label: contact.ui.steps.complete },
    ];
    const current = steps.findIndex((item) => item.id === step);
    return <ol className="contact-steps" aria-label={contact.ui.steps.aria}>{steps.map((item, index) => <li key={item.id} className={`contact-step ${index === current ? 'is-active' : ''} ${index < current ? 'is-complete' : ''}`} aria-current={index === current ? 'step' : undefined}><span className="contact-step__number">{index < current ? '✓' : index + 1}</span><span>{item.label}</span></li>)}</ol>;
}

function validate(values: FormValues, contact: ContactFixture): FormErrors {
    const errors: FormErrors = {}; const copy = contact.ui.errors;
    if (!values.customerType) errors.customerType = copy.customerType;
    if (!values.category) errors.category = copy.category;
    if (!values.name.trim()) errors.name = copy.name;
    if (!values.email.trim()) errors.email = copy.email;
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(values.email)) errors.email = copy.email_format;
    if (!values.phone.trim()) errors.phone = copy.phone;
    else if (!/^[0-9+()\-\s]{10,20}$/.test(values.phone)) errors.phone = copy.phone_format;
    if (!values.message.trim()) errors.message = copy.message;
    else if (values.message.trim().length < 10) errors.message = copy.message_length;
    if (!values.privacy) errors.privacy = copy.privacy;
    return errors;
}

function FieldLabel({ contact, name }: { contact: ContactFixture; name: string }) {
    const field = contact.fields[name];
    return <>{field.label}<span className={field.required ? 'required' : 'field__hint'}> {field.required ? contact.ui.required : contact.ui.optional}</span></>;
}

export default function ContactWizard({ contact, urls }: { contact: ContactFixture; urls: PublicPagePayload['urls'] }) {
    const [step, setStep] = useState<Step>('input');
    const [values, setValues] = useState<FormValues>(initialValues);
    const [errors, setErrors] = useState<FormErrors>({});
    const [attachments, setAttachments] = useState<Attachment[]>([]);
    const [attachmentError, setAttachmentError] = useState('');
    const [busy, setBusy] = useState(false);
    const errorRef = useRef<HTMLDivElement>(null); const busyRef = useRef(false); const completedRef = useRef(false); const attachmentsRef = useRef<Attachment[]>([]);

    useEffect(() => { attachmentsRef.current = attachments; }, [attachments]);
    useEffect(() => () => { attachmentsRef.current.forEach((item) => URL.revokeObjectURL(item.preview)); }, []);
    useEffect(() => {
        const handlePopState = () => {
            const path = window.location.pathname;
            if (path === new URL(urls.contactConfirm, window.location.origin).pathname && values.name) setStep('confirm');
            else if (path === new URL(urls.contactComplete, window.location.origin).pathname && completedRef.current) setStep('complete');
            else { setStep('input'); if (path !== new URL(urls.contact, window.location.origin).pathname) window.history.replaceState({ contactStep: 'input' }, '', urls.contact); }
        };
        window.addEventListener('popstate', handlePopState); return () => window.removeEventListener('popstate', handlePopState);
    }, [urls, values.name]);

    const setValue = <K extends keyof FormValues>(key: K, value: FormValues[K]) => { setValues((current) => ({ ...current, [key]: value })); setErrors((current) => ({ ...current, [key]: undefined })); };
    const handleFiles = (event: ChangeEvent<HTMLInputElement>) => {
        const selected = Array.from(event.target.files ?? []); setAttachmentError(''); event.target.value = '';
        if (attachments.length + selected.length > contact.attachment.maxFiles) { setAttachmentError(format(contact.ui.errors.files_count, { files: contact.attachment.maxFiles })); return; }
        const maximumBytes = contact.attachment.maxSizeMb * 1024 * 1024;
        if (selected.some((file) => !contact.attachment.accept.includes(file.type))) { setAttachmentError(contact.ui.errors.files_type); return; }
        if (selected.some((file) => file.size > maximumBytes)) { setAttachmentError(format(contact.ui.errors.files_size, { size: contact.attachment.maxSizeMb })); return; }
        setAttachments((current) => [...current, ...selected.map((file) => ({ file, preview: URL.createObjectURL(file) }))]);
    };
    const removeAttachment = (index: number) => { setAttachments((current) => { const target = current[index]; if (target) URL.revokeObjectURL(target.preview); return current.filter((_, itemIndex) => itemIndex !== index); }); };
    const goToConfirm = (event: FormEvent) => {
        event.preventDefault(); const nextErrors = validate(values, contact); setErrors(nextErrors);
        if (Object.keys(nextErrors).length > 0 || attachmentError) { window.requestAnimationFrame(() => errorRef.current?.focus()); return; }
        setStep('confirm'); window.history.pushState({ contactStep: 'confirm' }, '', urls.contactConfirm); document.querySelector('[data-contact-wizard]')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };
    const completePreview = () => {
        if (busyRef.current) return; busyRef.current = true; setBusy(true);
        window.setTimeout(() => { completedRef.current = true; setBusy(false); busyRef.current = false; setStep('complete'); window.history.pushState({ contactStep: 'complete' }, '', urls.contactComplete); }, 450);
    };
    const restart = () => { attachments.forEach((item) => URL.revokeObjectURL(item.preview)); setAttachments([]); setValues(initialValues); setErrors({}); setStep('input'); completedRef.current = false; window.history.replaceState({ contactStep: 'input' }, '', urls.contact); };
    const errorEntries = Object.entries(errors).filter((entry): entry is [string, string] => Boolean(entry[1]));

    return (
        <section className="contact-wizard" aria-labelledby="contact-wizard-title" aria-busy={busy}>
            <StepIndicator step={step} contact={contact} />
            {step === 'input' ? (
                <form className="contact-form" onSubmit={goToConfirm} noValidate autoComplete="off">
                    <div><span className="fixture-badge">{contact.ui.no_connection}</span><h2 id="contact-wizard-title">{contact.ui.input_title}</h2></div>
                    {errorEntries.length || attachmentError ? <div ref={errorRef} className="error-summary" role="alert" tabIndex={-1}><strong>{contact.ui.error_title}</strong><ul>{errorEntries.map(([key, message]) => <li key={key}><a href={`#contact-${key}`}>{message}</a></li>)}{attachmentError ? <li><a href="#contact-attachments">{attachmentError}</a></li> : null}</ul></div> : null}
                    <fieldset className="field" id="contact-customerType"><legend><FieldLabel contact={contact} name="customerType" /></legend><div className="choice-list">{contact.customerTypes.map((item) => <label key={item}><input type="radio" name="customerType" value={item} checked={values.customerType === item} onChange={() => setValue('customerType', item)} />{item}</label>)}</div>{errors.customerType ? <p className="field__error">{errors.customerType}</p> : null}</fieldset>
                    <div className="field"><label htmlFor="contact-category"><FieldLabel contact={contact} name="category" /></label><select id="contact-category" value={values.category} aria-invalid={Boolean(errors.category)} onChange={(event) => setValue('category', event.target.value)}><option value="">{contact.ui.select}</option>{contact.categories.map((item) => <option key={item}>{item}</option>)}</select>{errors.category ? <p className="field__error">{errors.category}</p> : null}</div>
                    <div className="contact-form__row"><div className="field"><label htmlFor="contact-name"><FieldLabel contact={contact} name="name" /></label><input id="contact-name" value={values.name} aria-invalid={Boolean(errors.name)} onChange={(event) => setValue('name', event.target.value)} />{errors.name ? <p className="field__error">{errors.name}</p> : null}</div><div className="field"><label htmlFor="contact-company"><FieldLabel contact={contact} name="company" /></label><input id="contact-company" value={values.company} onChange={(event) => setValue('company', event.target.value)} /></div></div>
                    <div className="contact-form__row"><div className="field"><label htmlFor="contact-email"><FieldLabel contact={contact} name="email" /></label><input id="contact-email" type="email" inputMode="email" value={values.email} aria-invalid={Boolean(errors.email)} onChange={(event) => setValue('email', event.target.value)} />{errors.email ? <p className="field__error">{errors.email}</p> : null}</div><div className="field"><label htmlFor="contact-phone"><FieldLabel contact={contact} name="phone" /></label><input id="contact-phone" type="tel" inputMode="tel" value={values.phone} aria-invalid={Boolean(errors.phone)} onChange={(event) => setValue('phone', event.target.value)} />{errors.phone ? <p className="field__error">{errors.phone}</p> : null}</div></div>
                    <div className="field"><label htmlFor="contact-message"><FieldLabel contact={contact} name="message" /></label><textarea id="contact-message" value={values.message} aria-invalid={Boolean(errors.message)} onChange={(event) => setValue('message', event.target.value)} /><span className="field__hint">{contact.ui.message_hint}</span>{errors.message ? <p className="field__error">{errors.message}</p> : null}</div>
                    <div className="field" id="contact-attachments"><label htmlFor="contact-file"><FieldLabel contact={contact} name="attachments" /></label><input id="contact-file" type="file" accept={contact.attachment.accept.join(',')} multiple onChange={handleFiles} /><span className="field__hint">{format(contact.ui.attachment_hint, { files: contact.attachment.maxFiles, size: contact.attachment.maxSizeMb })}</span>{attachmentError ? <p className="field__error">{attachmentError}</p> : null}{attachments.length ? <div className="attachment-list">{attachments.map((item, index) => <div className="attachment-preview" key={item.preview}><img src={item.preview} alt={format(contact.ui.attachment_alt, { number: index + 1 })} /><button type="button" aria-label={format(contact.ui.attachment_remove, { number: index + 1 })} onClick={() => removeAttachment(index)}>×</button></div>)}</div> : null}</div>
                    <div className="field" id="contact-privacy"><label className="choice-list"><span><input type="checkbox" checked={values.privacy} aria-invalid={Boolean(errors.privacy)} onChange={(event) => setValue('privacy', event.target.checked)} /> <strong>{contact.ui.privacy_label}</strong></span></label><span className="field__hint">{contact.privacySummary}</span>{errors.privacy ? <p className="field__error">{errors.privacy}</p> : null}</div>
                    <div className="contact-actions"><button className="button" type="submit">{contact.ui.confirm_button}</button></div>
                </form>
            ) : null}
            {step === 'confirm' ? (
                <div><span className="fixture-badge">{contact.ui.not_sent}</span><h2 id="contact-wizard-title">{contact.ui.confirm_title}</h2>
                    <dl className="confirm-list"><div className="confirm-list__row"><dt>{contact.fields.customerType.label}</dt><dd>{values.customerType}</dd></div><div className="confirm-list__row"><dt>{contact.ui.category_short}</dt><dd>{values.category}</dd></div><div className="confirm-list__row"><dt>{contact.fields.name.label}</dt><dd>{values.name}</dd></div><div className="confirm-list__row"><dt>{contact.fields.company.label}</dt><dd>{values.company || contact.ui.none}</dd></div><div className="confirm-list__row"><dt>{contact.ui.email_short}</dt><dd>{values.email}</dd></div><div className="confirm-list__row"><dt>{contact.ui.phone_short}</dt><dd>{values.phone}</dd></div><div className="confirm-list__row"><dt>{contact.ui.message_short}</dt><dd>{values.message}</dd></div><div className="confirm-list__row"><dt>{contact.ui.attachments_short}</dt><dd>{format(contact.ui.attachments_count, { count: attachments.length })}</dd></div></dl>
                    <div className="notice-box section-box">{contact.ui.confirm_notice}</div><div className="contact-actions"><button className="button button--outline" type="button" disabled={busy} onClick={() => { setStep('input'); window.history.pushState({ contactStep: 'input' }, '', urls.contact); }}>{contact.ui.edit}</button><button className="button" type="button" disabled={busy} aria-busy={busy} onClick={completePreview}>{busy ? contact.ui.switching : contact.ui.complete_preview}</button></div>
                </div>
            ) : null}
            {step === 'complete' ? <div className="complete-panel"><div className="complete-panel__mark" aria-hidden="true">✓</div><span className="fixture-badge">{contact.ui.preview}</span><h2 id="contact-wizard-title">{contact.ui.complete_title}</h2><p>{contact.ui.complete_text.split('\n').map((line, index) => <span key={line}>{line}{index === 0 ? <br /> : null}</span>)}</p><div className="notice-box complete-panel__notice">{contact.ui.complete_notice}</div><button className="button" type="button" onClick={restart}>{contact.ui.restart}</button></div> : null}
            <p className="sr-only" aria-live="polite">{format(contact.ui.current_screen, { step: contact.ui.steps[step] })}</p>
        </section>
    );
}
