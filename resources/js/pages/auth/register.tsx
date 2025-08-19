import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import { LoaderCircle } from 'lucide-react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import TextLink from '@/components/text-link';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';
type CustomerForm = {
    name: string;
    contact: string;
    email: string;
    address: string;
    dob: string;
};

export default function CustomerRegister() {
    const { data, setData, post, processing, errors } = useForm<CustomerForm>({
        name: '',
        contact: '',
        email: '',
        address: '',
        dob: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('register'));
    };

    return (
        <AuthLayout title="Customer Registration" description="Fill in your details to register">
            <Head title="Register as Customer" />
            <form className="flex flex-col gap-6" onSubmit={submit}>
                <div className="grid gap-6 rounded-xl border-2 border-zinc-500 dark:border-zinc-200 shadow-lg p-6">
                    <div className="grid gap-2">
                        <Label htmlFor="name">Full Name</Label>
                        <Input
                            id="name"
                            type="text"
                            required
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            disabled={processing}
                            autoFocus
                            placeholder="John Doe"
                        />
                        <InputError message={errors.name} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="contact">Contact Number</Label>
                        <Input
                            id="contact"
                            type="text"
                            required
                            value={data.contact}
                            onChange={(e) => setData('contact', e.target.value)}
                            disabled={processing}
                            placeholder="+1234567890"
                        />
                        <InputError message={errors.contact} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="email">Email Address</Label>
                        <Input
                            id="email"
                            type="email"
                            required
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            disabled={processing}
                            placeholder="email@example.com"
                        />
                        <InputError message={errors.email} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="address">Address</Label>
                        <Input
                            id="address"
                            type="text"
                            required
                            value={data.address}
                            onChange={(e) => setData('address', e.target.value)}
                            disabled={processing}
                            placeholder="123 Street Name, City"
                        />
                        <InputError message={errors.address} />
                    </div>

                    <div className="flex items-center gap-2">
                        <Label htmlFor="dob" className="whitespace-nowrap">Date of Birth</Label>
                        <DatePicker
                            id="dob"
                            selected={data.dob ? new Date(data.dob) : null}
                            onChange={date => setData('dob', date ? date.toISOString().split('T')[0] : '')}
                            maxDate={new Date()}
                            showMonthDropdown
                            showYearDropdown
                            dropdownMode="select"
                            dateFormat="yyyy-MM-dd"
                            placeholderText="YYYY-MM-DD"
                            disabled={processing}
                            required
                            className="flex-1 min-w-0 border-background dark:border-white rounded px-2 py-1 bg-transparent"
                        />
                        <InputError message={errors.dob} />
                    </div>

                    <Button type="submit" className="w-full mt-2" disabled={processing}>
                        {processing && <LoaderCircle className="w-4 h-4 mr-2 animate-spin" />}
                        Register
                    </Button>
                </div>

                <div className="text-center text-sm text-muted-foreground">
                    Already have an account?{' '}
                    <TextLink href={route('login')}>Log in</TextLink>
                </div>
            </form>
        </AuthLayout>
    );
}
