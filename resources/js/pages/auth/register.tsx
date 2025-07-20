import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import { LoaderCircle } from 'lucide-react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import TextLink from '@/components/text-link';

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
        post(route('customer.register')); // Change to match your route
    };

    return (
        <AuthLayout title="Customer Registration" description="Fill in your details to register">
            <Head title="Register as Customer" />
            <form className="flex flex-col gap-6" onSubmit={submit}>
                <div className="grid gap-6">
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

                    <div className="grid gap-2">
                        <Label htmlFor="dob">Date of Birth</Label>
                        <Input
                            id="dob"
                            type="date"
                            required
                            value={data.dob}
                            onChange={(e) => setData('dob', e.target.value)}
                            disabled={processing}
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
